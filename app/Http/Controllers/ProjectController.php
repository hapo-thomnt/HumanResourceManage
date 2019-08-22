<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employee;
use App\EmployProject;
use App\Project;
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
        $projects = Project::paginate(config('app.paginate'));
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
        $customers = Customer::all();
        $data = [
            'customers' => $customers,
        ];
        return view('projects.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $record = Project::create($input);

        return redirect()->route('projects.index')
            ->with('success', __('messages.project.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customer::all();
        $project = Project::find($id);
        $data = [
            'customers' => $customers,
            'project' => $project,
        ];

        return view('projects.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $input = $request->all();

        $project->update($input);

        return redirect()->route('projects.index')->with('success', __('messages.project.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if($project){
            $destroy = Project::destroy($id);
        }

        return redirect()->route('projects.index')->with('success', __('messages.project.delete.success'));
    }

    /**
     * Show the form for assign employee for project
     *
     * @return \Illuminate\Http\Response
     */
    public function editAssign($project_id)
    {
        $project = Project::with('employees')->find($project_id);
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
    public function updateAssign(Request $request,$project_id)
    {
        $project = Project::find($project_id);
        $employeeIds = $request->get('employee_id');
        $start_dates= $request->get('start_date');
        $end_dates = $request->get('end_date');
        $origin_start_dates= $request->get('origin_start_date');
        $origin_end_dates = $request->get('origin_end_date');
        $is_news = $request->get('is_new');

        $countEmployee = count($request->employee_id);
        for($i = 0; $i < $countEmployee; $i++){
            $employeeid =$employeeIds[$i];
            if (is_null($employeeid)){
                continue;
            }
            $tempStartDate = date($start_dates[$i]);
            $tempStartDate = date($end_dates[$i]);
            $data = [
                'start_date'=> date($start_dates[$i]),
                'end_date'=> date($end_dates[$i]),
            ];
            if(filter_var($is_news[$i],FILTER_VALIDATE_BOOLEAN)){
                $project->employees()->attach($employeeid,$data);
            }else{
                $project = Project::findOrFail($project_id);
                if($project){
                    $pivoteData = EmployProject::where('project_id', $project_id)
                        ->where('employee_id', $employeeid)
                        ->whereDate('start_date', date($origin_start_dates[$i]))
                        ->whereDate('end_date', date($origin_end_dates[$i]))
                        ->update(['start_date' =>  date($start_dates[$i]),
                            'end_date'=>  date($end_dates[$i])]);

                }
            }

        }

        return redirect()->route('project-assign.edit',$project_id)->with('success', __('messages.project.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $project_id,$employee_id
     * @return \Illuminate\Http\Response
     */
    public function destroyAssign($projectId,$employeeId, Request $request)
    {
        $project = Project::findOrFail($projectId);
        if($project){
            $pivoteData = EmployProject::where('project_id', $projectId)
                ->where('employee_id', $employeeId)
                ->whereDate('start_date', $request->startDate)
                ->whereDate('end_date', $request->endDate)
                ->first();
            $pivoteData->delete();
        }

        return redirect()->route('project-assign.edit',$projectId)->with('success', __('messages.project.delete.success'));
    }
}
