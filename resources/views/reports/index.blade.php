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
            <h2 class="display-4">Danh sách Báo cáo hàng ngày</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>No</td>
                    <td>Nhân viên</td>
                    <td>Ngày</td>
                    <td>Chú thích</td>
                    <td colspan=2>Thao tác</td>
                </tr>
                </thead>
                <tbody>
                @php($counter=0)
                @foreach($reports as $report)
                    @php($counter=$counter+1)
                    <tr>
                        <td>
                            <a href="{{ route('reports.show',$report->id)}}">{{ $counter }}</a>
                        </td>
                        <td>{{ $report->employee ? $report->employee->fullname : $report->employee }}</td>
                        <td>{{ $report->report_date }}</td>
                        <td>{{ $report->note }}</td>
                        <td>
                            <a href="{{ route('reports.edit',$report->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('reports.destroy', $report->id)}}" method="post">
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

            {{ $reports->links() }}
            <div>
                <div>
                    <a style="margin: 19px;" href="{{ route('reports.create')}}" class="btn btn-primary">Viết báo cáo</a>
                </div>
            </div>
@endsection

