@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Update a contact</h1>

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
            <form method="post" action="{{ route('employees.update', $employee->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">

                    <label for="firstname">Tên:</label>
                    <input type="text" class="form-control" name="firstname" value="{{ $employee->firstname }}"/>
                </div>

                <div class="form-group">
                    <label for="lastname">Họ:</label>
                    <input type="text" class="form-control" name="lastname" value="{{ $employee->lastname }}"/>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" value="{{ $employee->email }}"/>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu cũ:</label>
                    <input type="password" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu mới:</label>
                    <input type="password" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu mới(xác nhận):</label>
                    <input type="password" class="form-control" name="password"/>
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
