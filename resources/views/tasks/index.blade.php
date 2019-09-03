@extends('layout')
@section('css')
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet" type="text/css" />
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
                    <td>Trạng thái</td>
                    <td>Code</td>
                    <td>Name</td>
                    <td>Nhân viên phụ trách</td>
                    <td>Thuộc Dự án</td>
                    <td>Mô tả</td>
                    <td colspan = 2>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>
                            @foreach(config('app.task_status') as $key => $role)
                                @if($role == $task->status) {{ __("app.task_status.$key") }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $task->code }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->employee ? $task->employee->firstname : $task->employee }}</td>
                        <td>{{ $task->project ? $task->project->name : $task->project }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <a href="{{ route('tasks.edit',$task->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('tasks.destroy', $task->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $tasks->links() }}
            <div>
            </div>
@endsection

