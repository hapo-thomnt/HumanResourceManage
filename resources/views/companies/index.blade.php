@extends('layout')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if(session('content'))
                <div class="alert alert-{{ session('status') }}">
                    {{ session('content') }}
                </div>
            @endif
            <h2 class="display-4">Danh sách Công Ty</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Tên</td>
                    <td>Website</td>
                    <td>Địa chỉ</td>
                    <td colspan=2>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{ $company->name }} {{ $company->lastname }}</td>
                        <td>{{ $company->website  }}</td>
                        <td>{{ $company->address }}</td>
                        <td>
                            <a href="{{ route('companies.edit',$company->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('companies.destroy', $company->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $companies->links() }}
            <div>
            </div>
@endsection

