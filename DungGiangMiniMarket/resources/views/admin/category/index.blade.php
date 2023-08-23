@extends('layouts.app-admin')

@section('title', 'Loại hàng')

@section('styles')
 <!-- Custom styles for this page -->
 <link href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Quản lý loại hàng</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
        <button type=" button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
        <button type=" button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header has-add py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách loại hàng</h6>
        <a href="{{ route('admin.category.create') }}" class="btn btn-sm btn-primary shadow-sm">Thêm loại hàng</a>
    </div>
    <div class="card-body">
        <div class="table-reponsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên loại hàng</th>
                        <th>Đường dẫn ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->image}}</td>
                            <td>
                                <a href="{{ route( 'admin.category.edit', $item->id ) }}" class="btn btn-sm btn-success">Sửa</a>
                                <form action="{{ route( 'admin.category.destroy', $item->id ) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Xóa" class="btn btn-sm btn-danger">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')

    <!-- Page level plugins -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

@endpush