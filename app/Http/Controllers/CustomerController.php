<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
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
        $customers = Customer::paginate(config('app.paginate'));
        $data = [
            'customers' => $customers,
        ];
        return view('customers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        $data = [
            'companies' => $companies,
        ];
        return view('customers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $input = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            $storagePath = Storage::putFile('public/avatar/', $request->file('avatar'));
            $imageName = basename($storagePath);
        } else {
            $imageName = config('app.avatar_default');
        }
        $input['avatar'] = $imageName;

        $input['password'] = Hash::make($input['password']);

        $record = Customer::create($input);

        return redirect()->route('customers.index')
            ->with('success', __('messages.customer.create.success'));
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
        $customer = Customer::find($id);
        $companies = Company::all();
        $data = [
            'customer' => $customer,
            'companies' => $companies,
        ];
        return view('customers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $input = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            $storagePath = Storage::putFile('public/avatar/', $request->file('avatar'));
            $imageName = basename($storagePath);
            $input['avatar'] = $imageName;
        }

        $input['password'] = Hash::make($input['password']);

        $customer->update($input);

        return redirect()->route('customers.index')->with('success', __('messages.customer.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $destroy = Customer::destroy($id);
        }

        return redirect()->route('customers.index')->with('success', __('messages.customer.delete.success'));
    }
}
