@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-1">
            <h2>Báo cáo ngày {{ $report->report_date }}</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br/>
            @endif
            <table class="table" border="0">
                <tbody>
                <tr>
                    <td>Báo cáo của:</td>
                    <td>{{ $report->employee->fullname }}</td>
                </tr>
                <tr>
                    <td>Báo cáo cho ngày:</td>
                    <td>{{ $report->report_date }}</td>
                </tr>
                <tr>
                    <td>Chú thích:</td>
                    <td>{{ $report->note }}</td>
                </tr>
                </tbody>
            </table>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Dự án</th>
                    <th>Công việc</th>
                    <th>Thời gian</th>
                </tr>
                </thead>
                <tbody>
                @php($counter=0)
                @foreach ($report->tasks as $task)
                    @php($counter=$counter+1)
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>{{$task->project->name}}</td>
                        <td>{{$task->name}}</td>
                        <td>{{ $task->pivot->spent_time }}h</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <a href="{{ route('reports.edit',$report->id)}}" class="btn btn-primary">Sửa báo cáo này</a>
        </div>
    </div>
@endsection
