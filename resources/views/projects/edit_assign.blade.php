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
                <br/>
            @endif
            <h2>{{ $project->name }}</h2>
            <h4>Ngày bắt đầu: {{ $project->start_date }}</h4>
            <h4>Ngày kết thúc dự kiến: {{ $project->end_date }}</h4>
            <h4>Phân công nhân viên vào dự án:</h4>
            <form method="post" action="{{ route('project-assign.update', $project->id) }}">
                @method('PATCH')
                @csrf
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Nhân viên</td>
                        <td>Từ ngày</td>
                        <td>Đến ngày:</td>
                        <td>Vai trò trong dự án</td>
                        <td @cannot('project-edit-assign', $project)   hidden @endcannot>Thao tác</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($project->employees as $employee)
                        <tr>
                            <td><input type="hidden" name="employee_id[]"
                                       value="{{ $employee->id }} "/>{{ $employee->fullname }}
                            </td>
                            <input type="hidden" name="is_new[]" value="false"/>
                            <input type="hidden" name="origin_start_date[]" value="{{ $employee->pivot->start_date }}"/>
                            <input type="hidden" name="origin_end_date[]" value="{{ $employee->pivot->end_date }}"/>
                            <td><input type="date" class="form-control mb-2 mr-sm-2" name="start_date[]"
                                       value="{{ $employee->pivot->start_date }}"/></td>
                            <td><input type="date" class="form-control mb-2 mr-sm-2" name="end_date[]"
                                       value="{{ $employee->pivot->end_date }}"/></td>
                            <td>
                                <select name="role[]" class="form-control">
                                    @foreach(config('app.project_role') as $key => $role)
                                        <option @if($role == $employee->pivot->role) selected
                                                @endif value="{{ $role }}">
                                            {{ __("app.project_role.$key") }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <a class="btn btn-danger" @cannot('project-edit-assign', $project)   hidden @endcannot
                                onclick="deleteUserFromProject('{{ route('project-assign.destroy', ['projectId' => $project->id, 'employeeId' => $employee->id] ) }}', '{{ $employee->pivot->start_date }}', '{{ $employee->pivot->end_date }}')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div @cannot('project-edit-assign', $project)   hidden @endcannot>
                    <h3>Thêm mới nhân viên vào dự án:</h3>
                    <table class="table table-striped manager-employee">
                        <tr>
                            <th>Nhân viên</th>
                            <th>Từ ngày</th>
                            <th>Đến ngày</th>
                            <th>Vai trò trong dự án</th>
                            <th>Thao tác</th>
                        </tr>
                        <tr>
                            <td><select name="employee_id[]" class="form-control">
                                    <option></option>
                                    @foreach($employees as $employee)
                                        <option
                                            value="{{$employee->id}}"> {{ $employee->fullname}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <input type="hidden" name="is_new[]" value="true"/>
                            <td><input type="date" class="form-control" name="start_date[]"/></td>
                            <td><input type="date" class="form-control" name="end_date[]"/></td>
                            <td><select name="role[]" class="form-control">
                                    @foreach(config('app.project_role') as $key => $role)
                                        <option value="{{ $role }}">
                                            {{ __("app.project_role.$key") }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs btn-warning button-delete-employee">Delete
                                </button>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <button type="button" @cannot('project-edit-assign', $project)   disabled
                                @endcannot class="btn btn-xs btn-primary button-add-employee">Thêm nhân viên
                        </button>
                    </div>
                    <div class="form-group">
                        <button type="submit" @cannot('project-edit-assign', $project)   disabled
                                @endcannot class="btn btn-primary">Cập nhật phân công
                        </button>
                        <a href="{{ route('tasks.create')}}" class="btn btn-primary">Đăng ký task mới cho dự án</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.button-add-employee', function () {
                $('.manager-employee').append(`<tr>
                            <td><select name="employee_id[]" class="form-control">
                                    <option></option>
                                    @foreach($employees as $employee)
                    <option
                        value="{{$employee->id}}"> {{ $employee->fullname}}</option>
                                    @endforeach
                    </select>
                </td>
                <input type="hidden" name="is_new[]" value="true"/>
                <td><input type="date" class="form-control" name="start_date[]"/></td>
                <td><input type="date" class="form-control" name="end_date[]"/></td>
                <td><select name="role[]" class="form-control">
@foreach(config('app.project_role') as $key => $role)
                    <option value="{{ $role }}">
                                            {{ __("app.project_role.$key") }}
                    </option>
@endforeach
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-xs btn-warning button-delete-employee">Delete</button>
                </td>
            </tr>`)
            });
            $(document).on('click', '.button-delete-employee', function () {
                $(this).parent().parent().remove();
            });
        });

        function deleteUserFromProject(url, startDate, endDate) {
            var newUrl = url + '?startDate=' + startDate + '&endDate=' + endDate;
            window.location.href = newUrl;
        }
    </script>
@endsection
