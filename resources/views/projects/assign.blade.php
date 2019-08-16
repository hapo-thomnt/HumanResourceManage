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
            <form method="post" action="{{ route('project-assign.update', $project->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="name">Tên project:  </label>
                    <input type="text" class="form-control" name="name" value="{{ $project->name }}" readonly/>
                </div>
                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu :</label>
                    <input type="date" class="form-control" name="name" value="{{ $project->start_date }}" readonly/>
                </div>
                <div class="form-group">
                    <label for="end_date">Ngày kết thúc: </label>
                    <input type="date" class="form-control" name="name" value="{{ $project->end_date }}" readonly/>
                </div>
                <div class="form-group">
                    <label for="end_date">Cac nhan vien da phan cong: </label>
                    @foreach($project->employees as $employee)
                        <div class="form-inline">
                            <label for="show_name" class="mr-sm-2">Nhân viên:</label>
                            <input type="text" class="form-control  mb-2 mr-sm-2" name="show_name" value="{{ $employee->lastname }} {{ $employee->firstname }}" readonly/>
                            <label for="show_start_date" class="mr-sm-2">Từ ngày:</label>
                            <input type="date" class="form-control  mb-2 mr-sm-2" name="show_start_date" value="{{ $employee->pivot->start_date}}" />
                            <label for="show_end_date" class="mr-sm-2">Đến ngày:</label>
                            <input type="date" class="form-control  mb-2 mr-sm-2" name="show_end_date" value="{{ $employee->pivot->end_date}}" />
                        <div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="customer_id">Chọn nhân viên:</label>
                    <div class="form-inline">
                        <select name="employee_id[]" >
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}"> {{ $employee->lastname }} {{ $employee->firstname }}</option>
                            @endforeach
                        </select>
                        <input type="date" class="form-control mb-2 mr-sm-2" name="start_date" value="{{ $project->end_date }}" />
                        <input type="date" class="form-control mb-2 mr-sm-2" name="end_date" value="{{ $project->end_date }}" />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
