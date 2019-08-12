@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Thêm Công Ty
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
            <form method="post" action="{{ route('companies.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="name">Tên công ty:</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="website">Website:</label>
                    <input type="text" class="form-control" name="website"/>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ :</label>
                    <input type="text" class="form-control" name="address"/>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
