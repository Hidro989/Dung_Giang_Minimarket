@extends('layouts.app')
@section('title', 'Giỏ hàng')
@section('content')
    <!-- Hero Section Begin -->
    @include('includes.hero')
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Giỏ hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('/') }}">Trang chủ</a>
                            <span>Giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ( ! empty($carts) )
                                    @foreach ($carts as $item)
                                    <tr data-id="{{$item->id}}">
                                        <td class="shoping__cart__item">
                                            <img src="{{ url($item->featured_image)}}" alt="">
                                            <h5>{{$item->name}}</h5>
                                        </td>
                                        <td class="shoping__cart__price" data-price="{{$item->unit_price}}">
                                            {{$item->unit_price}}
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="{{$item->quantity}}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                            {{$item->unit_price * $item->quantity}}
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <span class="icon_close"></span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">TIẾP TỤC MUA HÀNG</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right" id="hui-btn-update-cart"><span class="icon_loading"></span>
                            CẬP NHẬT GIỎ HÀNG</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        {{-- <div class="shoping__discount">
                            <h5>Mã giảm giá</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Tổng số giỏ hàng</h5>
                        <ul>
                            {{-- <li>Tổng phụ <span></span></li> --}}
                            <li>Tổng <span id="hui-total-cart"></span></li>
                        </ul>
                        <a href="{{url('/checkout')}}" class="primary-btn">Tiến hành thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->    
@endsection

@push('scripts')
    <script>
        'use strict';
    (function ($) {
        
        setCurrencncey('.shoping__cart__price');
        setCurrencncey('.shoping__cart__total');
        loadTotal();

        $('.pro-qty').each(function (index, ele) {
            let numberQuantity = $(ele).find('input');
            let unitPirce = $(ele).closest('.shoping__cart__quantity').prev('.shoping__cart__price');
            let cartTotal = $(ele).closest('.shoping__cart__quantity').next('.shoping__cart__total');

            // de cart
            $(ele).find('.dec').on('click', function(){
                let oldValue = $(numberQuantity).val();
                let newVal = 0;
                if(oldValue > 0) {
                    newVal = parseInt(oldValue) - 1;
                }
                $(numberQuantity).val(newVal);
                $(cartTotal).text(formatCurrency( newVal * $(unitPirce).data('price') ));
                loadTotal();
            });

            // decrement cart
            $(ele).find('.inc').on('click', function(){
                let oldValue = $(numberQuantity).val();
                let newVal = 0;
                newVal = parseInt(oldValue) + 1;
                $(numberQuantity).val(newVal);
                $(cartTotal).text(formatCurrency( newVal * $(unitPirce).data('price') ));
                loadTotal();
            });
            
            // change quantity
            $(ele).find('input').on('change', function(e) {
                $(cartTotal).text(formatCurrency( $(this).val() * $(unitPirce).data('price') ));
                loadTotal();
            });
            

        });

        $('.shoping__cart__item__close').each(function (index, ele) {
            $(ele).on('click', function (e) {
                let data = {
                    'id' : $(ele).parent().data('id'),
                }

                $.ajax({
                    type: 'GET',
                    url: '/user/cart/destroy',
                    data: data,
                    async: false,
                    success: function(response) {
                        // alert(response.success);
                    },
                    error: function(response) {
                        // handleError(response);
                    }
                });
                $(ele).parent().remove();        
                loadTotal();

            });
        });

        $('#hui-btn-update-cart').on('click', function (e) {
            e.preventDefault();
            let cartItems = $('.shoping__cart__table').find('tbody > tr');
            $(cartItems).each(function (index, ele){
                let data = {
                    'id': $(ele).data('id'),
                    'quantity': $(ele).find('.shoping__cart__quantity input').val(),
                };

                $.ajax({
                    type: 'GET',
                    url: '/user/cart/update',
                    data: data,
                    async: false,
                    success: function(response) {
                        // alert(response.success);
                    },
                    error: function(response) {
                        // handleError(response);
                    }
                });
                
            });
        });

        

        function loadTotal(){
            let total = 0;
            $('.shoping__cart__total').each(function (index, ele) {
                var number = Number($(ele).text().replace(/[^0-9-]+/g,""));
                total += number;
                
            });
            $('#hui-total-cart').text(formatCurrency(total));
        }

        function setCurrencncey( selector ) {
            $(selector).each(function (index, ele) {
            let oldPrice = $(ele).text();
                $(ele).text(formatCurrency(oldPrice));
            });
        }


        function formatCurrency(currency) {
            const VND = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            });
            return VND.format(currency);
        }

    })(jQuery);
    </script>
@endpush