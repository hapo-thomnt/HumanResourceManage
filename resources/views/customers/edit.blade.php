@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Cập nhật khách hàng</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            <form method="post" action="{{ route('customers.update', $customer->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="lastname">Họ:</label>
                    <input type="text" class="form-control" name="lastname" value="{{ $customer->lastname }}" />
                </div>
                <div class="form-group">
                    <label for="firstname">Tên:</label>
                    <input type="text" class="form-control" name="firstname" value="{{ $customer->firstname }}" />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" value="{{ $customer->email }}" />
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩul:</label>
                    <input type="password" class="form-control" name="password" />
                </div>
                <div class="form-group">
                    <label for="phone">Điện thoại:</label>
                    <input type="text" class="form-control" name="phone" value="{{ $customer->phone }}" />
                </div>
                <div class="form-group">
                    <label for="address">Đại chỉ:</label>
                    <input type="text" class="form-control" name="adress" value="{{ $customer->address }}" />
                </div>
                <div class="form-group">
                    <label for="company_id">Làm việc cho công ty:</label>
                    <input type="text" class="form-control" name="company_id" value="{{ $customer->company->name }}" />
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
