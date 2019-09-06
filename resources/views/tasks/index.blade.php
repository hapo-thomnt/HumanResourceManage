@extends('layout')
@section('css')
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if(session('content'))
                <div class="alert alert-{{ session('status') }}">
                    {{ session('content') }}
                </div>
            @endif
            <h2 class="display-4">Danh sách Task</h2>
            <form class="form-inline" action="{{ route('tasks.index') }}" method="get">
                @csrf
                <div class="form-group">
                    <label for="status">Trạng thái:</label>
                    <select name="status" class="form-control">
                        <option selected value=""></option>
                        @foreach(config('app.task_status') as $key => $value)
                            <option @if($value == request('status') && request('status')!= null )  selected
                                    @endif value="{{ $value }}">
                                {{ __("app.task_status.$key") }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="code">Code:</label>
                    <input type="search" name="code" class="form-control" value="{{request('code')}}">
                </div>
                <div class="form-group">
                    <label for="name">Tên:</label>
                    <input type="search" name="name" class="form-control" value="{{request('name')}}">
                </div>
                <div class="form-group">
                    <label for="project_id">Project:</label>
                    <select name="project_id" class="form-control">
                        <option selected value=""></option>
                        @foreach($projects as $project)
                            <option @if(request('project_id') == $project->id) selected @endif
                            value="{{$project->id}}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="employee_id">Nhân viên phụ trách:</label>
                    <select name="employee_id" class="form-control">
                        <option selected value=""></option>
                        @foreach($employees as $employee)
                            <option @if(request('employee_id') == $employee->id) selected @endif
                            value="{{$employee->id}}">{{ $employee->fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Trạng thái</td>
                    <td>Code</td>
                    <td>Name</td>
                    <td>Nhân viên phụ trách</td>
                    <td>Thuộc Dự án</td>
                    <td>Mô tả</td>
                    <td colspan=2>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>
                            @foreach(config('app.task_status') as $key => $role)
                                @if($role == $task->status) {{ __("app.task_status.$key") }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $task->code }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->employee ? $task->employee->fullname : $task->employee }}</td>
                        <td>{{ $task->project ? $task->project->name : $task->project }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <a href="{{ route('tasks.edit',$task->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('tasks.destroy', $task->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $tasks->links() }}
            <div>
                <a style="margin: 19px;" href="{{ route('tasks.create')}}" class="btn btn-primary">Đăng ký task mới</a>
            </div>
            <div>
            </div>
@endsection

