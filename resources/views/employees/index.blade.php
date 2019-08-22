@extends('layout')
@section('css')
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <h2 class="display-4">Danh sách nhân viên</h2>
            <div>
                <a style="margin: 19px;" href="{{ route('employees.create')}}" class="btn btn-primary">Đăng ký nhân viên mới</a>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Avatar</td>
                    <td>Họ Tên</td>
                    <td>Email</td>
                    <td>Ngày sinh</td>
                    <td>Địa chỉ</td>
                    <td colspan=2>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>
                            <img class="avatar" src="{{ asset(config('app.file_path').$employee->avatar) }}" alt="avatar">
                        </td>
                        <td>{{ $employee->lastname }} {{ $employee->firstname }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->birthday }}</td>
                        <td>{{ $employee->adress }}</td>
                        <td>
                            <a href="{{ route('employees.edit',$employee->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('employees.destroy', $employee->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $employees->links() }}
            <div>
            </div>
@endsection

