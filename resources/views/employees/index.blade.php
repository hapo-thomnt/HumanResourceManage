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
            <h2 class="display-4">Danh sách nhân viên</h2>
            <div>
                <a style="margin: 19px;" href="{{ route('employees.create')}}" class="btn btn-primary">Đăng ký nhân viên mới</a>
            </div>
            <div class="col-md-4">
                <form action="{{ route('employees.index') }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="search" name="keyword" class="form-control" value="{{request('keyword')}}">
                        <span class="input-group-prepend">
                            <button type="submit" class="btn-primary">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Avatar</td>
                    <td>Họ Tên</td>
                    <td>Email</td>
                    <td>Loại nhân viên</td>
                    <td>Ngày sinh</td>
                    <td>Địa chỉ</td>
                    <td colspan=2>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>
                            <img class="avatar" src="{{ asset(config('app.file_path').$employee->avatar) }}"
                                 alt="avatar">
                        </td>
                        <td>{{ $employee->fullname }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>
                            @foreach(config('app.employee_role') as $key => $role)
                                @if($role == $employee->role) {{ __("app.employee_role.$key") }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{  date('d-m-Y', strtotime($employee->birthday))}}</td>
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

            {{ $employees->appends($_GET)->links() }}
            <div>
            </div>
@endsection

