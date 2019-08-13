@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Phân công dự án</h1>

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
            <form method="post" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="name">Tên project:  </label>
                    <input type="text" class="form-control" name="name" value="{{ $project->name }}" />
                </div>
                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu :</label>
                    <input type="date" class="form-control" name="name" value="{{ $project->start_date }}" />
                </div>
                <div class="form-group">
                    <label for="end_date">Ngày kết thúc: </label>
                    <input type="date" class="form-control" name="name" value="{{ $project->end_date }}" />
                </div>
                 <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
