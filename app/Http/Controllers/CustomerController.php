<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
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
    public function index(Request $request)
    {
        $search = $request->get('keyword');
        $customers = Customer::query();
        if ($request) {
            $customers->where('firstname', 'like', '%' . $search . '%')
                ->orwhere('lastname', 'like', '%' . $search . '%')
                ->orwhere('email', 'like', '%' . $search . '%')
                ->orwhere('phone', 'like', '%' . $search . '%')
                ->orwhere('address', 'like', '%' . $search . '%');
        }
        $data = [
            'customers' => $customers->paginate(config('app.paginate')),
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
            $imageName = self::getAvatarLink($request);
        } else {
            $imageName = config('app.avatar_default');
        }
        $input['avatar'] = $imageName;

        $input['password'] = Hash::make($input['password']);

        $record = Customer::create($input);
        if ($record) {
            $message = [
                'status' => 'success',
                'content' => __('messages.customer.create.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.customer.create.failure')
            ];
        }

        return redirect()->route('customers.index')
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
        $customer = Customer::findOrFail($id);
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
            $input['avatar'] = self::getAvatarLink($request);
        }

        $input['password'] = Hash::make($input['password']);

        $customer->update($input);
        if ($customer) {
            $message = [
                'status' => 'success',
                'content' => __('messages.customer.update.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.customer.update.failure')
            ];
        }

        return redirect()->route('customers.index')->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $message = [
            'status' => 'danger',
            'content' => __('messages.customer.delete.failure')
        ];
        if ($customer) {
            $destroy = Customer::destroy($id);
            if ($destroy) {
                $message = [
                    'status' => 'danger',
                    'content' => __('messages.customer.delete.success')
                ];
            }
        }

        return redirect()->route('customers.index')->with('success', __('messages.customer.delete.success'));
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
