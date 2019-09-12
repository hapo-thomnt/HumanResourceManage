<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Expr\Array_;

class TaskController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);
        $project_id = $request->get('project_id');
        $employee_id = $request->get('employee_id');
        $code = $request->get('code');
        $name = $request->get('name');
        $status = $request->get('status');

        $tasks = Task::query();
        if ($request) {
            $tasks->when($project_id, function ($query, $project_id) {
                return $query->where('project_id', $project_id);
            })
                ->when($employee_id, function ($query, $employee_id) {
                    return $query->where('employee_id', $employee_id);
                })
                ->when($code, function ($query, $code) {
                    return $query->where('code', 'like', '%' . $code . '%');
                })
                ->when($name, function ($query, $name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                })
                ->when($status, function ($query, $status) {
                    return $query->where('status', $status);
                });
        }

        $projects = Project::all();
        $employees = Employee::all();
        $data = [
            'tasks' => $tasks->paginate(config('app.paginate')),
            'projects' => $projects,
            'employees' => $employees,
        ];
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Task::class);
        $projects = Project::all();
        $projectEmployees=null;
        if(sizeof($projects)>0){
            $projectEmployees = self::getEmployeeInProject($projects[0]->id);
        }

        $data = [
            'employees' => $projectEmployees,
            'projects' => $projects,
        ];
        return view('tasks.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Task::class);
        $input = $request->all();

        $record = Task::create($input);
        if ($record) {
            $message = [
                'status' => 'success',
                'content' => __('messages.task.create.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.task.create.failure')
            ];
        }

        return redirect()->route('tasks.index')
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
        $task = Task::with('employee', 'project')->findOrFail($id);
        $this->authorize('update', $task);
        $projects = Project::all();
        $projectEmployees = self::getEmployeeInProject($task->project->id);
        $data = [
            'task' => $task,
            'projects' => $projects,
            'employees' => $projectEmployees,
        ];

        return view('tasks.edit', $data);
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
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        $task->update($request->all());
        if ($task) {
            $message = [
                'status' => 'success',
                'content' => __('messages.task.update.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.task.update.failure')
            ];
        }
        return redirect()->route('tasks.index')->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);
        $message = [
            'status' => 'danger',
            'content' => __('messages.task.delete.failure')
        ];
        if ($task) {
            $destroy = Task::destroy($id);
            if ($destroy) {
                $message = [
                    'status' => 'success',
                    'content' => __('messages.task.delete.success')
                ];
            }
        }

        return redirect()->route('tasks.index')->with($message);
    }

    /**
     * Show all employee in project
     *
     * @param int $projectId
     * @return Array_
     */
    public function getEmployeeInProject($projectId)
    {
        $project = Project::with('employees')->findOrFail($projectId);
        $employees = $project->employees;
        $employees = self::getRemovedDuplicateEmployee($employees);
        return $employees;
    }

    /**
     * remove all duplicate employee in array
     *
     * @param array $employees
     * @return Array
     */
    private function getRemovedDuplicateEmployee($employees)
    {
        if (sizeof($employees) <= 1) {
            return $employees;
        }

        $result = array();
        array_push($result, $employees[1]);

        foreach ($employees as $tempEmployee) {
            if (self::isEmployeeInArray($tempEmployee, $result)) {
                continue;
            };
            array_push($result, $tempEmployee);
        }
        return $result;
    }

    /**
     * remove all duplicate employee in array
     *
     * @param $employee
     * @param $array
     * @return boolean
     */
    private function isEmployeeInArray($employee, $employees)
    {
        foreach ($employees as $tempEmployee) {
            if ($employee->id == $tempEmployee->id) {
                return true;
            };
        }
        return false;
    }
}
