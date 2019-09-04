<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use mysql_xdevapi\Collection;

class TaskController extends Controller
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
    public function index(Request $request)
    {
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
        $employees= Employee::all();
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
        $employees = Employee::all();
        $projects = Project::all();
        $data = [
            'employees' => $employees,
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
        //
    }

    /**
     * Show all employee in project
     *
     * @param int $projectId
     * @return Collection
     */
    private function getEmployeeInProject($projectId)
    {
        $project = Project::with('employees')->findOrFail($projectId);
        $employees = $project->employees;

        return $employees;
    }
}
