<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Task;
use App\Models\ReportTask;
use Illuminate\Http\Request;
use PhpParser\Builder;

class ReportController extends Controller
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
        return view('reports.create', $data);
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
        //save to report table
        $report = Report::create($input);

        //save to report_task pivot table
        $taskIds = $request->task_id;
        $spent_times = $request->spent_time;
        for ($i = 0; $i < count($taskIds); $i++) {
            $taskId = $taskIds[$i];
            if (is_null($taskId)) {
                continue;
            }

            $data = [
                'report_id' => $report->id,
                'spent_time' => $spent_times[$i],
            ];

            $report->tasks()->attach($taskId, $data);

        }

        if ($report) {
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

        return redirect()->route('reports.show', $report->id)
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
        $report = Report::with('tasks')->findOrFail($id);
        $data = [
            'report' => $report,
        ];

        return view('reports.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = Report::with('tasks')->findOrFail($id);
        $employeeTasks = self::getTasksOfEmployee(auth()->user()->id);
        $data = [
            'report' => $report,
            'employeeTasks' => $employeeTasks,
        ];

        return view('reports.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $reportId)
    {
        $report = Report::findOrFail($reportId);
        $report->update($request->all());

        $taskIds = $request->task_id;
        $spent_times = $request->spent_time;
        $origin_spent_times = $request->origin_spent_time;
        $is_news = $request->is_new;
        $is_deleted_items = $request->is_deleted;
        for ($i = 0; $i < count($taskIds); $i++) {
            $taskId = $taskIds[$i];
            if (is_null($taskId)) {
                continue;
            }

            $data = [
                'spent_time' => $spent_times[$i],
            ];
            //delete from pivot table
            if (filter_var($is_deleted_items[$i], FILTER_VALIDATE_BOOLEAN)) {
                self::destroyTaskFromReport($reportId, $taskId, $origin_spent_times[$i]);
            }
            //add to pivot table
            if (filter_var($is_news[$i], FILTER_VALIDATE_BOOLEAN)) {
                $report->tasks()->attach($taskId, $data);
            } else {
                //update
                $pivoteData = ReportTask::where('task_id', $taskId)
                    ->where('report_id', $reportId)
                    ->where('spent_time', $origin_spent_times[$i])
                    ->update(['spent_time' => $spent_times[$i]]);
            }
        }

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
        return redirect()->route('reports.show', $reportId)->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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
     * Remove the specified resource from storage.
     *
     * @param int $project_id ,$employee_id
     * @return \Illuminate\Http\Response
     */
    public function destroyTask($reportId, $taskId, Request $request)
    {

        $pivoteData = ReportTask::where('report_id', $reportId)
            ->where('task_id', $taskId)
            ->where('spent_time', $request->spent_time)
            ->first();
        $pivoteData->delete();

        return redirect()->route('reports.edit', $reportId)->with('success', __('messages.project.delete.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $project_id ,$employee_id
     * @return \Illuminate\Http\Response
     */
    private function destroyTaskFromReport($reportId, $taskId, $spentTime)
    {

        $pivoteData = ReportTask::where('report_id', $reportId)
            ->where('task_id', $taskId)
            ->where('spent_time', $spentTime)
            ->first();
        $pivoteData->delete();
    }

    /**
     * Get all task assigned to an employee
     *
     * @param int $employee
     * @return Builder
     */
    private function getTasksOfEmployee($employeeId)
    {
        $tasks = Task::where('employee_id', $employeeId)->get();
        return $tasks;
    }
}
