@extends('layouts.app-admin')
 
@section('title', 'Products')
 
@php 
    $product = true;
    $index = 'active';
@endphp
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Quản lý mặt hàng</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header has-add py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
            <a href="{{ route('admin.product.create')}}" class="btn btn-primary">Thêm sản phẩm</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id}}</td>
                                <td> <a href="{{route('admin.product.edit', $product->id)}}"><img src="{{ $product->featured_image }}" alt="" width="50px"></a> </td>
                                <td><a href="{{ route('admin.product.edit',$product->id)}}">{{ $product->name}}</a></td>
                                <td>{{ $product->category->name}}</td>
                                <td>{{ $product->unit_price}}</td>
                                <td>{{ $product->stock}}</td>
                                <td>
                                <form action="{{ route('admin.product.destroy', $product->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></button>
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