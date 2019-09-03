<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
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
            $tasks->where('project_id',$project_id )
                ->orwhere('employee_id', $employee_id )
                ->orwhere('code', 'like', '%' . $code . '%')
                ->orwhere('name', 'like', '%' . $name . '%')
                ->orwhere('status', $status );
        }
        $data = [
            'tasks' => $tasks->paginate(config('app.paginate')),
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
     * @param  \Illuminate\Http\Request  $request
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
