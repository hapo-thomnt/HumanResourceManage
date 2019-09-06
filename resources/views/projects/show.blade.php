@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-1">
            <h1 class="display-3">Thông tin dự án</h1>

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
            <table class="table" border="0">
                <tbody>
                <tr>
                    <td>Tên project:</td>
                    <td>{{ $project->name }}</td>
                </tr>
                <tr>
                    <td>Ngày bắt đầu :</td>
                    <td>{{ $project->start_date }}</td>
                </tr>
                <tr>
                    <td>Ngày kết thúc:</td>
                    <td>{{ $project->end_date }}</td>
                </tr>
                <tr>
                    <td>Khách hàng phụ trách:</td>
                    <td>{{ $project->customer->fullname }}</td>
                </tr>
                <tr>
                    <td>Mô tả:</td>
                    <td>{{ $project->description }}</td>
                </tr>
                <tr>
                    <td><a href="{{ route('project-assign.edit',$project->id)}}" class="btn btn-primary">Phân công</a></td>
                    <td><a href="{{ route('tasks.create')}}" class="btn btn-primary">Đăng ký task mới cho dự án</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
