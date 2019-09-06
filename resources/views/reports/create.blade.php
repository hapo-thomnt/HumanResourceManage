@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Viết Báo Cáo Hàng Ngày
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
            <form method="post" action="{{ route('reports.store') }}">
                @csrf
                <div class="form-inline">
                    <h4>Tên nhân viên: </h4><h2>{{auth()->user()->fullname}}</h2>
                </div>
                <div class="form-group">
                        <input type="hidden" class="form-control" name="employee_id" value="{{auth()->user()->id}}"/>
                </div>
                <div class="form-group">
                    <label for="start_date">Ngày :</label>
                    <input type="date" class="form-control" name="report_date" value="{{date("Y-m-d")}}"/>
                </div>
                <div class="form-group manager-employee">
                    <div class="form-inline">
                        <select name="task_id[]" class="form-control">
                            <option></option>
                            @foreach($tasks as $task)
                                <option
                                    value="{{$task->id}}">{{ $task->code}}   {{ $task->name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="is_new[]" value="true"/>
                        <input type="number" class="form-control" name="spent_time[]" value="0"/>
                        <button type="button" class="btn btn-xs btn-warning button-delete-employee">Delete</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="note">Chú thích:</label>
                    <textarea class="form-control" name="note"/></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
