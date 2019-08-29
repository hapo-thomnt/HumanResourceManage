<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\EmployProject;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('customer')->paginate(config('app.paginate'));
        $data = [
            'projects' => $projects,
        ];
        return view('projects.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-project');
        $customers = Customer::all();
        $data = [
            'customers' => $customers,
        ];
        return view('projects.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $record = Project::create($input);
        if ($record) {
            $message = [
                'status' => 'success',
                'content' => __('messages.project.create.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.project.create.failure')
            ];
        }

        return redirect()->route('projects.index')
            ->with($message);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with('employees')->findOrFail($id);
        $customers = Customer::all();
        $data = [
            'customers' => $customers,
            'project' => $project,
        ];

        return view('projects.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        if ($project) {
            $message = [
                'status' => 'success',
                'content' => __('messages.project.update.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.project.update.failure')
            ];
        }
        return redirect()->route('projects.index')->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $message = [
            'status' => 'danger',
            'content' => __('messages.project.delete.failure')
        ];
        if ($project) {
            $destroy = Project::destroy($id);
            if ($destroy) {
                $message = [
                    'status' => 'danger',
                    'content' => __('messages.project.delete.success')
                ];
            }
        }

        return redirect()->route('projects.index')->with($message);
    }

    /**
     * Show the form for assign employee for project
     *
     * @return \Illuminate\Http\Response
     */
    public function editAssign($project_id)
    {
        $project = Project::with('employees')->findOrFail($project_id);
        $employees = Employee::all();
        $data = [
            'project' => $project,
            'employees' => $employees,
        ];
        return view('projects.index_assign', $data);
    }

    /**
     * update assign information of a project
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAssign(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $employeeIds = $request->get('employee_id');
        $start_dates = $request->get('start_date');
        $end_dates = $request->get('end_date');
        $origin_start_dates = $request->get('origin_start_date');
        $origin_end_dates = $request->get('origin_end_date');
        $is_news = $request->get('is_new');
        $roles = $request->get('role');

        $countEmployee = count($request->employee_id);
        for ($i = 0; $i < $countEmployee; $i++) {
            $employeeId = $employeeIds[$i];
            if (is_null($employeeId)) {
                continue;
            }

            $data = [
                'start_date' => date($start_dates[$i]),
                'end_date' => date($end_dates[$i]),
                'role' => $roles[$i],
            ];
            if (filter_var($is_news[$i], FILTER_VALIDATE_BOOLEAN)) {
                //update information of employee in project
                $project->employees()->attach($employeeId, $data);
            } else {
                //add new employee to project
                $project = Project::findOrFail($project_id);
                if ($project) {
                    $pivoteData = EmployProject::where('project_id', $project_id)
                        ->where('employee_id', $employeeId)
                        ->whereDate('start_date', date($origin_start_dates[$i]))
                        ->whereDate('end_date', date($origin_end_dates[$i]))
                        ->update(['start_date' => date($start_dates[$i]),
                            'end_date' => date($end_dates[$i]),
                            'role' => $roles[$i]]);
                }
            }
        }

        return redirect()->route('project-assign.edit', $project_id)->with('success', __('messages.project.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $project_id ,$employee_id
     * @return \Illuminate\Http\Response
     */
    public function destroyAssign($projectId, $employeeId, Request $request)
    {
        $project = Project::findOrFail($projectId);
        if ($project) {
            $pivoteData = EmployProject::where('project_id', $projectId)
                ->where('employee_id', $employeeId)
                ->whereDate('start_date', $request->startDate)
                ->whereDate('end_date', $request->endDate)
                ->first();
            $pivoteData->delete();
        }

        return redirect()->route('project-assign.edit', $projectId)->with('success', __('messages.project.delete.success'));
    }
}
