@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Sửa Báo Cáo Hàng Ngày
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
            <form method="post" action="{{ route('reports.update',$report->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-inline">
                    <h4>Tên nhân viên: </h4><h2>{{ $report->employee->fullname }}</h2>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="employee_id" value="{{auth()->user()->id}}"/>
                </div>
                <div class="form-group">
                    <label for="start_date">Ngày :</label>
                    <input type="date" class="form-control" name="report_date" value="{{ $report->report_date }}"/>
                </div>
                <div class="form-group">
                    <label for="note">Chú thích:</label>
                    <textarea class="form-control" name="note"/>{{ $report->note }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
