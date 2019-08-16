@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Phân công dự án</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            <h2>{{ $project->name }}</h2>
            <h4>Ngày bắt đầu: {{ $project->start_date }}</h4>
            <h4>Ngày kết thúc dự kiến: {{ $project->end_date }}</h4>
            <h4>Danh sách nhân viên đã phân công:</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Nhân viên</td>
                    <td>Từ ngày</td>
                    <td>Đến ngày:</td>
                    <td>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @foreach($project->employees as $employee)
                    <tr>
                        <td>{{ $employee->lastname }} {{ $employee->firstname }}</td>
                        <td>{{ $employee->pivot->start_date}}</td>
                        <td>{{ $employee->pivot->end_date}}</td>
                        <td>
                            <a class="btn btn-danger" href="{{ route('project-assign.destroy', ['projectId' => $project->id, 'employeeId' => $employee->id] ) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h3>Chọn nhân viên:</h3>
            <form method="post" action="{{ route('project-assign.update', $project->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group manager-employee">
                    <div class="form-inline">
                        <select name="employee_id[]" >
                                <option></option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}"> {{ $employee->lastname }} {{ $employee->firstname }}</option>
                            @endforeach
                        </select>
                        <input type="date" class="form-control mb-2 mr-sm-2" name="start_date[]" value="{{ $project->end_date }}" />
                        <input type="date" class="form-control mb-2 mr-sm-2" name="end_date[]" value="{{ $project->end_date }}" />
                        <button type="button" class="btn btn-xs btn-warning button-delete-employee">Delete</button>
                    </div>
                </div>
                <button type="button" class="btn btn-xs btn-primary button-add-employee">Thêm</button>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.button-add-employee', function () {
                $('.manager-employee').append(`<div class="form-inline">
                        <select name="employee_id[]" >
                                <option></option>
                            @foreach($employees as $employee)
                    <option value="{{$employee->id}}"> {{ $employee->lastname }} {{ $employee->firstname }}</option>
                            @endforeach
                    </select>
                    <input type="date" class="form-control mb-2 mr-sm-2" name="start_date[]" value="{{ $project->end_date }}" />
                        <input type="date" class="form-control mb-2 mr-sm-2" name="end_date[]" value="{{ $project->end_date }}" />
                        <button type="button" class="btn btn-xs btn-warning button-delete-employee">Delete</button>
                    </div>`)
            });
            $(document).on('click', '.button-delete-employee', function () {
                $(this).parent().remove();
            });
        });
    </script>
@endsection
