@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Cập nhật task</h1>

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
            <form method="post" action="{{ route('tasks.update', $task->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value ="{{$task->name}}"/>
                </div>
                <div class="form-group">
                    <label for="code">Code:</label>
                    <input type="text" class="form-control" name="code" value ="{{$task->code}}"/>
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái:</label>
                    <select name="status" class="form-control">
                        @foreach(config('app.task_status') as $key => $value)
                            <option @if($value == $task->status) selected
                                    @endif value="{{ $value }}">
                                {{ __("app.task_status.$key") }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="project_id">Thuộc dự án:</label>
                    <select name="project_id" class="form-control select-project"
                            onchange="setEmployeesInProject('{{route('task.get-employee-in-project',100000)}}',$(this).val())">
                        @foreach($projects as $project)
                            <option @if($task->project?$task->project->id == $project->id: false) selected @endif
                                value="{{$project->id}}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="employee_id">Nhân viên phụ trách:</label>
                    <select name="employee_id" class="form-control employeee">
                        @foreach($employees as $employee)
                            <option @if($task->employee?$task->employee->id == $employee->id: false) selected @endif
                            value="{{$employee->id}}">{{ $employee->fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <textarea class="form-control" name="description"/></textarea>
                </div>
                <button   @cannot('edit-task', $task->project->id)   disabled    @endcannot       type="submit" class="btn btn-primary">Cập Nhật</button>
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
