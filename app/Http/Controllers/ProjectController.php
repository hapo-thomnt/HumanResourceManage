<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Employee;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function assign($id)
    {
        $project = Project::find($id);
        $employees = Employee::all();
        $data = [
            'project' => $project,
            'employees' => $employees,
        ];
        return view('projects.assign', $data);
    }

    /**
     * Show the form for assign employee for project
     *
     * @return \Illuminate\Http\Response
     */
    public function assignUpdate($id)
    {
        $project = Project::find($id);
        $employees = Employee::all();
        $data = [
            'project' => $project,
            'employees' => $employees,
        ];
        return view('projects.assign', $data);
    }
}
