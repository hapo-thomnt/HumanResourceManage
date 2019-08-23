<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate(config('app.paginate'));
        $data = [
            'companies' => $companies,
        ];
        return view('companies.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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

        $company = Company::create($input);
        if($company){
            $message = [
                'status' => 'success',
                'content' => __('messages.company.create.success')
            ];
        }else{
            $message = [
                'status' => 'danger',
                'content' => __('messages.company.create.failure')
            ];
        }

        return redirect()->route('companies.index')
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
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
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
        $company = Company::findOrFail($id);
        $company->update($request->all());

        if($company){
            $message = [
                'status' => 'success',
                'content' => __('messages.company.update.success')
            ];
        }else{
            $message = [
                'status' => 'danger',
                'content' => __('messages.company.update.failure')
            ];
        }
        return redirect()->route('companies.index')->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $message = [
            'status' => 'danger',
            'content' => __('messages.company.delete.failure')
        ];
        if ($company) {
            $destroy = Company::destroy($id);
            if ($destroy) {
                $message = [
                    'status' => 'danger',
                    'content' => __('messages.company.delete.success')
                ];
            }
        }

        return redirect()->route('companies.index')->with($message);
    }
}
