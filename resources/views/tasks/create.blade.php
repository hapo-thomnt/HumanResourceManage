@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Thêm Task
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br/>
            @endif
            <form method="post" action="{{ route('tasks.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="code">Code:</label>
                    <input type="text" class="form-control" name="code"/>
                </div>
                <div class="form-group">
                    <label for="project_id">Thuộc dự án:</label>
                    <select name="project_id" class="form-control">
                        @foreach($projects as $project)
                            <option
                                value="{{$project->id}}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="employee_id">Nhân viên phụ trách:</label>
                    <select name="employee_id" class="form-control">
                        @foreach($employees as $employee)
                            <option
                                value="{{$employee->id}}">{{ $employee->firstname }} {{ $employee->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="status" value = "{{ config('app.task_status.new') }}"/>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <input type="text" class="form-control" name="description"/>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
