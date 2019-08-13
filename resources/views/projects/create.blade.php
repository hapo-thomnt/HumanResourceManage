@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Thêm Project
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
            <form method="post" action="{{ route('projects.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Tên project:</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu :</label>
                    <input type="date" class="form-control" name="start_date"/>
                </div>
                <div class="form-group">
                    <label for="end_date">Ngày kết thúc:</label>
                    <input type="date" class="form-control" name="end_date"/>
                </div>
                <div class="form-group">
                    <label for="customer_id">Khách hàng phụ trách:</label>
                    <select name="customer_id">
                        @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{ $customer->firstname }} {{ $customer->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <input type="text" class="form-control" name="description"/>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
