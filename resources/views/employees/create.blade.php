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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('employees.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="name">Họ:</label>
                    <input type="lastname" class="form-control" name="lastname"/>
                </div>
                <div class="form-group">
                    <label for="firstname">Tên :</label>
                    <input type="text" class="form-control" name="firstname"/>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email"/>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày sinh:</label>
                    <input type="text" class="form-control" name="birthday"/>
                </div>
                <div class="form-group">
                    <label for="adress">Địa chỉ:</label>
                    <input type="text" class="form-control" name="adress"/>
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
