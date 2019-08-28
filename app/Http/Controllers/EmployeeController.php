<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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
    public function index(Request $request)
    {
        $search = $request->get('keyword');
        $employees = Employee::query();
        if ($request) {
            $employees->where('firstname', 'like', '%' . $search . '%')
                ->orwhere('lastname', 'like', '%' . $search . '%')
                ->orwhere('email', 'like', '%' . $search . '%')
                ->orwhere('phone', 'like', '%' . $search . '%')
                ->orwhere('address', 'like', '%' . $search . '%');
        }
        $data = [
            'employees' => $employees->paginate(config('app.paginate')),
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $input = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $imageName = self::getAvatarLink($request);
        } else {
            $imageName = config('app.avatar_default');
        }
        $input['avatar'] = $imageName;
        $input['password'] = Hash::make($input['password']);
        $user = Employee::create($input);
        if ($user) {
            $message = [
                'status' => 'success',
                'content' => __('messages.employee.create.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.employee.create.failure')
            ];
        }

        return redirect()->route('employees.index')
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
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $input = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $input['avatar'] = self::getAvatarLink($request);
        }

        $employee->update($input);
        if ($employee) {
            $message = [
                'status' => 'success',
                'content' => __('messages.employee.update.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.employee.update.failure')
            ];
        }

        return redirect()->route('employees.index')->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Employee::findOrFail($id);
        $message = [
            'status' => 'danger',
            'content' => __('messages.employee.delete.failure')
        ];
        if ($contact) {
            $destroy = Employee::destroy($id);
            if ($destroy) {
                $message = [
                    'status' => 'danger',
                    'content' => __('messages.employee.delete.success')
                ];
            }
        }

        return redirect()->route('employees.index')->with($message);
    }

    /**
     * Save image uploaded .
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    private function getAvatarLink(Request $request)
    {
        $imageName = null;
        if ($request->hasFile('avatar')) {
            $storagePath = Storage::putFile(config('app.avatar_path'), $request->file('avatar'));
            $imageName = basename($storagePath);
        }
        return $imageName;
    }

}
