@extends('layouts.app')
@section('title', 'Thanh toán thành công')
@section('content')
    <!-- Hero Section Begin -->
    @include('includes.hero')
    <!-- Hero Section End -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12" >
                <div class="d-flex flex-column justify-content-center align-items-center" style="height: 500px">
                    <p class="display-4" style="color: #7fad39">
                        <i class="fa fa-check-circle"></i> Đặt hàng thành công
                    </p>
                    <p class="text-center">
                        Chúc mừng quý khách hàng đã thanh toán thành công đơn hàng <strong>{{$order_id}}</strong> tại Dũng Giang Mart.
                        Nhân viên chăm sóc khách hàng của chúng tôi sẽ liên hệ với quý khách hàng khi đơn hàng được xác nhận.
                        Quý khách hàng cũng có thể theo dõi đơn hàng bằng cách đăng nhập và theo dõi đơn hàng trên website của chúng tôi.
                    </p>
                    <div class="d-flex justify-content-center mb-4 ">
                        <a href="{{ route('/') }}" class="btn btn-outline-primary ml-3">
                            Trang chủ
                        </a>
                    </div>
                </div>
                
        </div>
        
       </div>
    </div>
@endsection