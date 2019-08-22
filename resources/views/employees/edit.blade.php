@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Update a contact</h1>
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
                    <input type="text" class="form-control" name="birthday" value="{{ $employee->birthday }}"/>
                </div>
                <div class="form-group">
                    <label for="adress">Đại chỉ:</label>
                    <input type="text" class="form-control" name="adress" value="{{ $employee->adress }}"/>
                </div>
                <div class="form-group">
                    <label for="avatar">Hình đại diện:</label>
                    <input type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control" name="avatar"/>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
            </form>
        </div>
    </div>
@endsection
