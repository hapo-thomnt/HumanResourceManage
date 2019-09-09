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
                <table class="table table-striped manager-employee">
                    <tr>
                        <td>Công việc:</td>
                        <td>
                            <select name="task_id[]" class="form-control">
                                <option></option>
                                @foreach($tasks as $task)
                                    <option
                                        value="{{$task->id}}">{{ $task->code}}   {{ $task->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>Số giờ:</td>
                        <td><input type="number" class="form-control" name="spent_time[]" value="0"/></td>
                        <td><button type="button" class="btn btn-xs btn-warning button-delete-employee">Delete</button></td>
                    </tr>
                </table>
                <div class="form-group">
                    <button type="button" class="btn btn-xs btn-primary button-add-employee">Thêm công việc để đăng ký</button>
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
@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.button-add-employee', function () {
                $('.manager-employee').append('<tr>\n' +
                    '                        <td>Công việc:</td>\n' +
                    '                        <td>\n' +
                    '                            <select name="task_id[]" class="form-control">\n' +
                    '                                <option></option>\n' +
                    '                                @foreach($tasks as $task)\n' +
                    '                                    <option\n' +
                    '                                        value="{{$task->id}}">{{ $task->code}}   {{ $task->name}}</option>\n' +
                    '                                @endforeach\n' +
                    '                            </select>\n' +
                    '                        </td>\n' +
                    '                        <td>Số giờ:</td>\n' +
                    '                        <td><input type="number" class="form-control" name="spent_time[]" value="0"/></td>\n' +
                    '                        <td><button type="button" class="btn btn-xs btn-warning button-delete-employee">Delete</button></td>\n' +
                    '                    </tr>')
            });
            $(document).on('click', '.button-delete-employee', function () {
                $(this).parent().parent().remove();
            });
        });
    </script>
@endsection
