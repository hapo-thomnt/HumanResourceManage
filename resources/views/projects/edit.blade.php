@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Cập nhật thông tin dự án</h1>

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
            <form method="post" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="name">Tên project:</label>
                    <input type="text" class="form-control" name="name" value="{{ $project->name }}"/>
                </div>
                <div class="form-group">
                    <label for="start_date">Ngày bắt đầu :</label>
                    <input type="date" class="form-control" name="start_date" value="{{ $project->start_date }}"/>
                </div>
                <div class="form-group">
                    <label for="end_date">Ngày kết thúc:</label>
                    <input type="date" class="form-control" name="end_date" value="{{ $project->end_date }}"/>
                </div>
                <div >
                    <label for="customer_id">Khách hàng phụ trách:</label>
                    <select name="customer_id" class="form-group">
                        @foreach($customers as $customer)
                            <option @if($project->customer?$project->customer->id == $customer->id: false) selected
                                    @endif value="{{$customer->id}}">{{ $customer->fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <textarea class="form-control" name="description"/> {{ $project->description }}</textarea>
                </div>
                <button    type="submit" class="btn btn-primary">Cập Nhật</button>
            </form>
        </div>
    </div>
@endsection
