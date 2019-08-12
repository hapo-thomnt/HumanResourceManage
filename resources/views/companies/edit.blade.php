@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Update a contact</h1>

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
            <form method="post" action="{{ route('companies.update', $employee->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">

                    <label for="name">ên công ty:</label>
                    <input type="text" class="form-control" name="name" value="{{ $employee->name }}" />
                </div>
                <div class="form-group">
                    <label for="website">Website:</label>
                    <input type="text" class="form-control" name="website" value="{{ $employee->website }}" />
                </div>
                <div class="form-group">
                    <label for="adress">Địa chỉ :</label>
                    <input type="text" class="form-control" name="address" value="{{ $employee->address }}" />
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
            </form>
        </div>
    </div>
@endsection
