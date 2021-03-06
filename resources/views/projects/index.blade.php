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
            <h2 class="display-4">Danh sách Dự án</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Tên dự án</td>
                    <td>Ngày bắt đầu</td>
                    <td>Ngày kết thúc dự kiến</td>
                    <td>Khách hàng phụ trách</td>
                    <td>Mô tả</td>
                    <td>Phân công dự án</td>
                    <td colspan=2>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>
                            <a href="{{ route('projects.show',$project->id)}}">{{ $project->name }}</a>
                        </td>
                        <td>{{ $project->start_date }}</td>
                        <td>{{ $project->end_date }}</td>
                        <td>{{ $project->customer ? $project->customer->fullname : $project->customer }}</td>
                        <td>{{ $project->description }}</td>
                        <td>
                            <a href="{{ route('project-assign.edit',$project->id)}}" class="btn btn-primary">Phân công</a>
                        </td>
                        <td>
                            <a href="{{ route('projects.edit',$project->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('projects.destroy', $project->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" @cannot('delete-project')   disabled
                                        @endcannot    type="submit">Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $projects->links() }}
            <div>
            </div>
@endsection

