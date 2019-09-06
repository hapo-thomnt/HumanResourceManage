<?php

namespace App\Http\Controllers;
use App\Models\Report;

use App\Models\Task;
use Illuminate\Http\Request;
use PhpParser\Builder;

class ReportController extends Controller
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
        $reports = Report::with('employee')->paginate(config('app.paginate'));
        $data = [
            'reports' => $reports,
        ];
        return view('reports.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-report');
        $tasks = self::getTasksOfEmployee(auth()->user()->id);

        $data = [
            'tasks' => $tasks,
        ];
        return view('reports.create',$data);
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

        $record = Report::create($input);
        if ($record) {
            $message = [
                'status' => 'success',
                'content' => __('messages.report.create.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.report.create.failure')
            ];
        }

        return redirect()->route('reports.show',$record->id)
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
        $report = Report::with('employee')->findOrFail($id);
        $data = [
            'report' => $report,
        ];

        return view('reports.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = Report::with('employee')->findOrFail($id);
        $data = [
            'report' => $report,
        ];

        return view('reports.edit', $data);
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
        $report = Report::findOrFail($id);
        $report->update($request->all());
        if ($report) {
            $message = [
                'status' => 'success',
                'content' => __('messages.report.update.success')
            ];
        } else {
            $message = [
                'status' => 'danger',
                'content' => __('messages.report.update.failure')
            ];
        }
        return redirect()->route('reports.show',$id)->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Report::findOrFail($id);
        $message = [
            'status' => 'danger',
            'content' => __('messages.report.delete.failure')
        ];
        if ($project) {
            $destroy = Report::destroy($id);
            if ($destroy) {
                $message = [
                    'status' => 'success',
                    'content' => __('messages.report.delete.success')
                ];
            }
        }

        return redirect()->route('reports.index')->with($message);
    }

    /**
     * Get all task assigned to an employee
     *
     * @param int $employee
     * @return Builder
     */
    private function getTasksOfEmployee($employeeId)
    {
        $tasks = Task::where('employee_id',$employeeId)->firstOrFail();
        return $tasks;
    }
}
