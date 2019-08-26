@extends('layout')
@section('css')
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Thêm Khách Hàng
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Họ:</label>
                    <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}"/>
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
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}"/>
                    @if ($errors->first('email'))
                        <div class="alert alert-danger">
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" class="form-control" name="password"/>
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày sinh:</label>
                    <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}"/>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"/>
                </div>
                <div class="form-group">
                    <label for="company_id">Tên công ty:</label>
                    <select name="company_id">
                        @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="avatar">Upload Avatar:</label>
                    <input type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control" name="avatar" onchange="loadFile(event)"/>
                    <img class="preview_avatar hidden" id="output"/>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
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
