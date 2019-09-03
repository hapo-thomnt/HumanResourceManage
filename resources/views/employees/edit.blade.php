@extends('layout')
@section('css')
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h4 class="display-4">Update Employee Information</h4>
            <form method="post" action="{{ route('employees.update', $employee->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">

                    <label for="firstname">Tên:</label>
                    <input type="text" class="form-control" name="firstname" value="{{ $employee->firstname }}"/>
                    @if ($errors->first('firstname'))
                        <div class="alert alert-danger">
                            {!! $errors->first('firstname', '<p class="help-block">:message</p>') !!}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="lastname">Họ:</label>
                    <input type="text" class="form-control" name="lastname" value="{{ $employee->lastname }}"/>
                    @if ($errors->first('lastname'))
                        <div class="alert alert-danger">
                            {!! $errors->first('lastname', '<p class="help-block">:message</p>') !!}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" value="{{ $employee->email }}"/>
                    @if ($errors->first('email'))
                        <div class="alert alert-danger">
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="adress">Ngày sinh:</label>
                    <input type="date" class="form-control" name="birthday" value="{{ $employee->birthday }}"/>
                </div>
                <div class="form-group">
                    <label for="adress">Đại chỉ:</label>
                    <input type="text" class="form-control" name="adress" value="{{ $employee->adress }}"/>
                </div>
                <div class="form-group">
                    <label for="role">Loại nhân viên:</label>
                    <select name="role" class="form-control">
                        @foreach(config('app.employee_role') as $key => $role)
                            <option @if($role == $employee->role) selected
                                    @endif value="{{ $role }}">
                                {{ __("app.employee_role.$key") }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="avatar">Hình đại diện:</label>
                    <input type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control" name="avatar" onchange="loadFile(event)"/>
                    <img class="preview_avatar hidden" id="output"/>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.classList.remove('hidden');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endsection
