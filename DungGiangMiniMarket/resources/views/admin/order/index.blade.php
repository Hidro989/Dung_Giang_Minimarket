@extends('layouts.app-admin')

@section('title', 'Đơn hàng')

@section('styles')
 <!-- Custom styles for this page -->
 <link href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Quản lý loại hàng</h1>
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
        <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
    </div>
    <div class="card-body">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="awaiting-confirmation-tab" data-toggle="tab" href="#awaiting-confirmation" role="tab" aria-controls="awaiting-confirmation" aria-selected="true">Chờ xác nhận</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="delivering-tab" data-toggle="tab" href="#delivering" role="tab" aria-controls="delivering" aria-selected="false">Đang giao</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="delivered-tab" data-toggle="tab" href="#delivered" role="tab" aria-controls="delivered" aria-selected="false">Đã giao</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="return-tab" data-toggle="tab" href="#return" role="tab" aria-controls="return" aria-selected="false">Hoàn trả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cancel-tab" data-toggle="tab" href="#cancel" role="tab" aria-controls="cancel" aria-selected="false">Hủy</a>
                </li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade active show" id="awaiting-confirmation" role="tabpanel" aria-labelledby="awaiting-confirmation-tab">
                    <div class="table-reponsive mt-3">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Khách hàng</th>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu đơn hàng</th>
                                    <th>Thời gian tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($list_orders as $item)
                                    @if($item['status'] === 0) 
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><strong>Họ và tên:</strong> {{$item['fullname']}}</span>
                                                    <span><strong>Ngày sinh:</strong> {{$item['date_of_birth']}}</span>
                                                    <span><strong>Giới tính:</strong> @switch($item['gender'])
                                                        @case(0)
                                                            {{'Nam'}}
                                                            @break
                                                        @case(1)
                                                            {{'Nữ'}}
                                                            @break
                                                        @default
                                                            {{'Khác'}}
                                                            
                                                    @endswitch</span>
                                                    <span><strong>Địa chỉ nhận hàng:</strong> {{$item['address']}}</span>
                                                    <span><strong>Số điện thoại:</strong> {{$item['phone']}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($item['order_details'] as $detail)
                                                    <div class="d-flex">
                                                        <img src="{{ url($detail->featured_image) }}" height="40" width="40" class="p-2">
                                                        <span class="p-2">{{$detail->name}}</span>
                                                        <span class="ml-auto p-2">x{{$detail->quantity}}</span>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>{{$item['total_price']}}</td>
                                            <td>{{$item['created_date']}}</td>
                                            <td>Chờ xác nhận</td>
                                            <td>
                                                <a href="{{ route('admin.order.update_status', ['id'=> $item['id'], 'new_status' => 1])}}" class="btn btn-sm btn-success">Xác nhận</a>
                                                <a href="{{ route('admin.order.update_status', ['id'=> $item['id'], 'new_status' => 4])}}" class="btn btn-sm btn-danger">Hủy</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="delivering" role="tabpanel" aria-labelledby="delivering-tab">
                    <div class="table-reponsive mt-3">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Khách hàng</th>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu đơn hàng</th>
                                    <th>Thời gian tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_orders as $item)
                                    @if($item['status'] === 1) 
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><strong>Họ và tên:</strong> {{$item['fullname']}}</span>
                                                    <span><strong>Ngày sinh:</strong> {{$item['date_of_birth']}}</span>
                                                    <span><strong>Giới tính:</strong> {{$item['gender']}}</span>
                                                    <span><strong>Địa chỉ nhận hàng:</strong> {{$item['address']}}</span>
                                                    <span><strong>Số điện thoại:</strong> {{$item['phone']}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($item['order_details'] as $detail)
                                                    <div class="d-flex">
                                                        <img src="{{ url($detail->featured_image) }}" height="40" width="40" class="p-2">
                                                        <span class="p-2">{{$detail->name}}</span>
                                                        <span class="ml-auto p-2">x{{$detail->quantity}}</span>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>{{$item['total_price']}}</td>
                                            <td>{{$item['created_date']}}</td>
                                            <td>Đang giao</td>
                                            <td>
                                                <a href="{{ route('admin.order.update_status', ['id'=> $item['id'], 'new_status' => 2])}}" class="btn btn-sm btn-success">Đã giao</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                    <div class="table-reponsive mt-3">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Khách hàng</th>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu đơn hàng</th>
                                    <th>Thời gian tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_orders as $item)
                                    @if($item['status'] === 2) 
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><strong>Họ và tên:</strong> {{$item['fullname']}}</span>
                                                    <span><strong>Ngày sinh:</strong> {{$item['date_of_birth']}}</span>
                                                    <span><strong>Giới tính:</strong> {{$item['gender']}}</span>
                                                    <span><strong>Địa chỉ nhận hàng:</strong> {{$item['address']}}</span>
                                                    <span><strong>Số điện thoại:</strong> {{$item['phone']}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($item['order_details'] as $detail)
                                                    <div class="d-flex">
                                                        <img src="{{ url($detail->featured_image) }}" height="40" width="40" class="p-2">
                                                        <span class="p-2">{{$detail->name}}</span>
                                                        <span class="ml-auto p-2">x{{$detail->quantity}}</span>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>{{$item['total_price']}}</td>
                                            <td>{{$item['created_date']}}</td>
                                            <td>Đã giao</td>
                                            <td>
                                                <a href="{{ route('admin.order.update_status', ['id'=> $item['id'], 'new_status' => 3])}}" class="btn btn-sm btn-success">Hoàn trả</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
                    <div class="table-reponsive mt-3">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Khách hàng</th>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu đơn hàng</th>
                                    <th>Thời gian tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_orders as $item)
                                    @if($item['status'] === 3) 
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><strong>Họ và tên:</strong> {{$item['fullname']}}</span>
                                                    <span><strong>Ngày sinh:</strong> {{$item['date_of_birth']}}</span>
                                                    <span><strong>Giới tính:</strong> {{$item['gender']}}</span>
                                                    <span><strong>Địa chỉ nhận hàng:</strong> {{$item['address']}}</span>
                                                    <span><strong>Số điện thoại:</strong> {{$item['phone']}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($item['order_details'] as $detail)
                                                    <div class="d-flex">
                                                        <img src="{{ url($detail->featured_image) }}" height="40" width="40" class="p-2">
                                                        <span class="p-2">{{$detail->name}}</span>
                                                        <span class="ml-auto p-2">x{{$detail->quantity}}</span>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>{{$item['total_price']}}</td>
                                            <td>{{$item['created_date']}}</td>
                                            <td>Hoàn trả</td>
                                            <td>
                                                <a href="{{ route('admin.order.update_status', ['id'=> $item['id'], 'new_status' => 2])}}" class="btn btn-sm btn-success">Đã giao</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                    <div class="table-reponsive mt-3">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Khách hàng</th>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu đơn hàng</th>
                                    <th>Thời gian tạo</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_orders as $item)
                                    @if($item['status'] === 4) 
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><strong>Họ và tên:</strong> {{$item['fullname']}}</span>
                                                    <span><strong>Ngày sinh:</strong> {{$item['date_of_birth']}}</span>
                                                    <span><strong>Giới tính:</strong> {{$item['gender']}}</span>
                                                    <span><strong>Địa chỉ nhận hàng:</strong> {{$item['address']}}</span>
                                                    <span><strong>Số điện thoại:</strong> {{$item['phone']}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($item['order_details'] as $detail)
                                                    <div class="d-flex">
                                                        <img src="{{ url($detail->featured_image) }}" height="40" width="40" class="p-2">
                                                        <span class="p-2">{{$detail->name}}</span>
                                                        <span class="ml-auto p-2">x{{$detail->quantity}}</span>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>{{$item['total_price']}}</td>
                                            <td>{{$item['created_date']}}</td>
                                            <td>Hủy</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $('#myTab li a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            })
        });

    </script>

@endpush