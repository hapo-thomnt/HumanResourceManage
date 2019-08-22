@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Thêm nhân viên
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('employees.store') }}" enctype="multipart/form-data">
                <div class="form-group">
                    @csrf
                    <label for="name">Họ:</label>
                    <input type="lastname" class="form-control" name="lastname" value="{{ old('lastname') }}"/>
                    @if ($errors->first('lastname'))
                        <div class="alert alert-danger">
                            {!! $errors->first('lastname', '<p class="help-block">:message</p>') !!}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="firstname">Tên :</label>
                    <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}"/>
                    @if ($errors->first('firstname'))
                        <div class="alert alert-danger">
                            {!! $errors->first('firstname', '<p class="help-block">:message</p>') !!}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"/>
                    @if ($errors->first('email'))
                        <div class="alert alert-danger">
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}"/>
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày sinh:</label>
                    <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}"/>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" class="form-control" name="address" value="{{ old('address') }}"/>
                </div>
                <div class="form-group">
                    <label for="avatar">Upload Avatar:</label>
                    <input type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control" name="avatar"/>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
