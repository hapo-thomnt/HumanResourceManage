@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Thông tin Phân công dự án</h1>

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
            <h2>Tên dự án: {{ $project->name }}</h2>
            <h4>Ngày bắt đầu: {{ $project->start_date }}</h4>
            <h4>Ngày kết thúc dự kiến: {{ $project->end_date }}</h4>
            <h2>Danh sách nhân viên đã phân công:</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Nhân viên</td>
                    <td>Từ ngày</td>
                    <td>Đến ngày:</td>
                    <td>Vai trò</td>
                </tr>
                </thead>
                <tbody>
                @foreach($project->employees as $employee)
                    <tr>
                        <td>{{ $employee->fullname }}</td>
                        <td>{{ $employee->pivot->start_date }}</td>
                        <td>{{ $employee->pivot->end_date }}</td>
                        <td>
                            @foreach(config('app.project_role') as $key => $role)
                                @if($role == $employee->pivot->role)
                                    {{ __("app.project_role.$key") }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="{{ route('project-assign.edit',$project->id)}}" class="btn btn-primary">Chỉnh sửa Thông tin Phân công</a>
        </div>
    </div>
@endsection
