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
                    <h4>Tên nhân viên: </h4>
                    <h2>{{ $report->employee->fullname }}</h2>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="employee_id" value="{{auth()->user()->id}}"/>
                </div>
                <div class="form-group">
                    <label for="start_date">Ngày :</label>
                    <input type="date" class="form-control" name="report_date" value="{{ $report->report_date }}"/>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
{{--                        <th>Thuộc dự án</th>--}}
{{--                        <th>Code</th>--}}
                        <th>Nội dung Công việc</th>
                        <th>Thời gian</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody class=" manager-employee">

                    @foreach ($report->tasks as $task)
                        <tr>
                            <input type="hidden" name="is_new[]" value="false"/>
                            <input type="hidden" class="is_deleted_item" name="is_deleted[]" value="false"/>
                            <input type="hidden" name="task_id[]" value="{{ $task->id}}"/>
                            <input type="hidden" name="origin_spent_time[]" value="{{ $task->pivot->spent_time }}"/>
{{--                            <td><input type="text" class="form-control" readonly value="{{$task->project->name}}"></td>--}}
{{--                            <td><input type="text" class="form-control" readonly value="{{ $task->code}}"></td>--}}
                            <td><input type="text" class="form-control" readonly value="{{ $task->name}}"></td>
                            <td><input type="number" class="form-control" name="spent_time[]"
                                       value="{{ $task->pivot->spent_time }}"/></td>
                            <td>
                                <button type="button" class="btn btn-xs btn-warning button-delete-employee-origin">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div class="form-group">
                    <button type="button" class="btn btn-xs btn-primary button-add-employee">Thêm công việc để đăng ký
                    </button>
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
@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.button-add-employee', function () {
                $('.manager-employee').append('<tr>\n' +
                    '                            <td>\n' +
                    '                                <select name="task_id[]" class="form-control">\n' +
                    '                                    <option></option>\n' +
                    '                                    @foreach($employeeTasks as $item)\n' +
                    '                                        <option \n' +
                    '                                            value="{{$item->id}}">{{ $item->code}}   {{ $item->name}}</option>\n' +
                    '                                    @endforeach\n' +
                    '                                </select>\n' +
                    '                            </td>\n' +
                    '                            <td><input type="number" class="form-control" name="spent_time[]" value="0"/></td>\n' +
                    '                            <input type="hidden" class="form-control" name="is_new[]" value="true"/>\n' +
                    '                            <input type="hidden" class="form-control" name="is_deleted[]" value="false"/>\n' +
                    '                            <td><button type="button" class="btn btn-xs btn-warning button-delete-employee">Delete</button></td>\n' +
                    '                        </tr>')
            });
            $(document).on('click', '.button-delete-employee-origin', function () {
                $(this).parent().parent().addClass('hidden');
                $(this).parent().parent().find('.is_deleted_item').val(true);
            });
            $(document).on('click', '.button-delete-employee', function () {
                $(this).parent().parent().remove();
            });
        });
    </script>
@endsection
