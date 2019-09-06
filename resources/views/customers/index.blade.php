@extends('layout')
@section('css')
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if(session('content'))
                <div class="alert alert-{{ session('status') }}">
                    {{ session('content') }}
                </div>
            @endif
            <div class="col-md-4">
                <form action="{{ route('customers.index') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="search" name="keyword" class="form-control" value="{{request('keyword')}}">
                        <span class="input-group-prepend">
                            <button type="submit" class="btn-primary">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <h2 class="display-4">Danh sách Khách hàng</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Avatar</td>
                    <td>Họ Tên</td>
                    <td>Email</td>
                    <td>Điện thoại</td>
                    <td>Địa chỉ</td>
                    <td>Tên công ty</td>
                    <td colspan=2>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>
                            <img class="avatar" src="{{ asset(config('app.file_path').$customer->avatar) }}"
                                 alt="avatar">
                        </td>
                        <td>{{ $customer->fullname }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->company->name }}</td>
                        <td>
                            <a href="{{ route('customers.edit',$customer->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('customers.destroy', $customer->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $customers->appends($_GET)->links() }}
            <div>
            </div>
@endsection

