@extends('layouts.app-admin')
 
@section('title', 'Products')
 
@php 
    $product = true;
    $index = 'active';
@endphp
@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Quản lý mặt hàng</h1>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
            <button type=" button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
                                    <div class="btn btn-danger btn-circle" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-trash-o"></i></div>
                                </form>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- modal --}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Xóa sản phẩm</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Bạn có chắc chắn muốn xóa sản phẩm ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
              <button type="button" class="btn btn-danger" id="confirmBtn">Đồng ý</button>
            </div>
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
        var activeBtn;
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $('#exampleModalCenter').on('show.bs.modal',function (e){
            activeBtn = $(e.relatedTarget);
        });
        $('#confirmBtn').on('click',function(){
            activeBtn.parent().submit();
            $('#exampleModalCenter').modal('hide');
        })

    </script>

@endpush