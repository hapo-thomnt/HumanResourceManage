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
                    <select name="project_id" class="form-control select-project"
                            onchange="setEmployeesInProject('{{route('task.get-employee-in-project',100000)}}',$(this).val())">
                        @foreach($projects as $project)
                            <option
                                value="{{$project->id}}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="employee_id">Nhân viên phụ trách:</label>
                    <select name="employee_id" class="form-control employeee">
                        @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{ $employee->fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="status"
                           value="{{ config('app.task_status.new') }}"/>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <textarea class="form-control" name="description"/></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function setEmployeesInProject(Url, projectID) {
            var newUrl = Url.replace(100000, projectID);
            $.ajax({
                url: newUrl,
                type: 'GET',
                data: {
                    'numberOfWords': 10
                },
                dataType: 'json',
                success: function (data) {
                    var $employeee = $('.employeee');
                    $employeee.empty();

                    for (let i = 0; i < data.length; i++) {
                        var o = new Option(data[i].fullname, data[i].id);
                        $(".employeee").append(o);
                    }
                },
                error: function (request, error) {
                    //do nothing
                }
            });
        }
    </script>
@endsection
