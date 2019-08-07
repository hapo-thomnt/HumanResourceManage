<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
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
        $employees = Employee::paginate(config('app.paginate'));
        $data = [
            'employees' => $employees,
        ];
        return view('employees.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployee $request)
    {
        $input = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $storagePath = Storage::putFile('public/avatar/', $request->file('avatar'));
            $imageName  = basename($storagePath);
        } else {
            $imageName= config('app.avatar_default');
        }
        $input['avatar']  = $imageName;

        $input['password'] =  Hash::make($input['password']);

        $user = Employee::create($input);

        return redirect()->route('employees.index')
            ->with('success', __('messages.employee.create.success'));
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
        $employee = Employee::find($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployee $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $input = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $storagePath = Storage::putFile ('public/avatar/', $request->file('avatar'));
            $imageName = basename($storagePath);
            $input['avatar'] = $imageName;
        }

        $input['password'] =  Hash::make($input['password']);

        $employee->update($input);

        return redirect()->route('employees.index')->with('success', __('messages.employee.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Employee::find($id);
        if($contact){
            $destroy = Employee::destroy($id);
        }

        return redirect()->route('employees.index')->with('success', __('messages.employee.delete.success'));
    }
}
