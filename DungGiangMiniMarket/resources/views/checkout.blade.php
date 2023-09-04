@extends('layouts.app')
@section('title', 'Thanh toán')
@section('styles')
    <style type="text/css">
        .hui-payment-method-item {
            display: flex;
            align-items: center;
            border: 1px solid #D9D9D9;
            border-radius: 16px;
            padding: 15px 20px;
            cursor: pointer;
            transition: 0.2s all;
            opacity: 0.6;
            margin-bottom: 16px;
        }

        .hui-payment-method-item.active {
            border: 1px solid #2f5acf;
            opacity: 1;
        }

        .hui-payment-method-item.active .hui-radio-input {
            border: 1px solid #2f5acf;
        }


        .hui-radio-input {
            display: block;
            position: relative;
            flex: 0 0 20px;
            width: 20px;
            height: 20px;
            border: 1px solid #d9d9d9;
            border-radius: 20px;
            transition: all .2s;
        }

        .hui-radio-input input {
            display: none;
        }

        .hui-radio-input input:checked~.checkmark {
            display: block;
        }

        .hui-radio-input .checkmark {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 10px;
            height: 10px;
            border-radius: 20px;
            background-color: #2f5acf;
        }

        .hui-radi-icon-wrap {
            margin: 0 1.5rem;
        }

        .hui-radi-icon-wrap img {
            min-width: 35px;
            max-height: 35px;
            max-width: 55px;
        }
    </style>
@endsection
@section('content')
    <!-- Hero Section Begin -->
    @include('includes.hero')
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Thanh toán</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('/')}}">Trang chủ</a>
                            <span>Thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Chi tiết hóa đơn</h4>
                <form action="{{ route('user.order.stored')}}" id="checkoutForm" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Họ và tên<span>*</span></p>
                                        <input type="text" placeholder="Họ và tên" value="{{ $user->fullname }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Địa chỉ<span>*</span></p>
                                <input type="text" placeholder="Địa chỉ" class="checkout__input__add" value="{{ $user->address }}" name="main_address">
                                <input type="text" placeholder="Căn hộ, dãy phòng, căn hộ, v.v. (tùy chọn)" name="sub_address">
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Số điện thoại<span>*</span></p>
                                        <input type="text" value="{{ $user->phone }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <h4>Hình thức thanh toán</h4>
                                <div class="hui-radio-payment">
                                    <label for="payment_cod" class="hui-payment-method-item active">
                                        <span class="hui-radio-input">
                                            <input type="radio" name="payment_form" id="payment_cod" value="cod" checked>
                                            <span class="checkmark"></span>
                                        </span>
                                        <span class="hui-radi-icon-wrap">
                                            <img src="{{ asset('assets/img/payment-icon/COD.svg') }}" alt="">
                                        </span>
                                        <span class="hui-radio-input-name">
                                            COD
                                            <br />
                                            Thanh toán khi nhận hàng
                                        </span>
                                    </label>
                                    <label for="payment_zalo" class="hui-payment-method-item">
                                        <span class="hui-radio-input">
                                            <input type="radio" name="payment_form" id="payment_zalo" value="zalo">
                                            <span class="checkmark"></span>
                                        </span>
                                        <span class="hui-radi-icon-wrap">
                                            <img src="{{ asset('assets/img/payment-icon/logo-zalopay.svg') }}" alt="">
                                        </span>
                                        <span class="hui-radio-input-name">
                                            Ví điện tử Zalo Pay
                                        </span>
                                    </label>
                                    <label for="payment_momo" class="hui-payment-method-item">
                                        <span class="hui-radio-input">
                                            <input type="radio" name="payment_form" id="payment_momo" value="momo">
                                            <span class="checkmark"></span>
                                        </span>
                                        <span class="hui-radi-icon-wrap">
                                            <img src="{{ asset('assets/img/payment-icon/momo-icon.webp') }}" alt="">
                                        </span>
                                        <span class="hui-radio-input-name">
                                            Thanh toán MoMo
                                        </span>
                                    </label>
                                    <label for="payment_vnpay" class="hui-payment-method-item">
                                        <span class="hui-radio-input">
                                            <input type="radio" name="payment_form" id="payment_vnpay" value="vnpay">
                                            <span class="checkmark"></span>
                                        </span>
                                        <span class="hui-radi-icon-wrap">
                                            <img src="{{ asset('assets/img/payment-icon/vnpay.webp') }}" alt="">
                                        </span>
                                        <span class="hui-radio-input-name">
                                            Thẻ ATM / Thẻ tín dụng(Credit card) / Thẻ ghi nợ(Debit card)
                                        </span>
                                    </label>
                                    <label for="payment_qr" class="hui-payment-method-item">
                                        <span class="hui-radio-input">
                                            <input type="radio" name="payment_form" id="payment_qr" value="qr">
                                            <span class="checkmark"></span>
                                        </span>
                                        <span class="hui-radi-icon-wrap">
                                            <img src="{{ asset('assets/img/payment-icon/mceclip1_21.webp') }}" alt="">
                                        </span>
                                        <span class="hui-radio-input-name">
                                            Chuyển khoản liên ngân hàng bằng QR Code<br>Chuyển tiền qua ví điện tử (MoMo, Zalopay,...)
                                        </span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Đơn hàng của bạn</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Tổng</span></div>
                                @if ( ! empty($carts))
                                    <ul>
                                        @foreach ($carts as $item)
                                        <li>{{ $item->name }}
                                            <span class="cart-total" data-price="{{ $item->unit_price * $item->quantity }}"></span>
                                            <input type="hidden" name="cart_items[]" value="{{ $item->id }}">
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                                {{-- <div class="checkout__order__subtotal">Tổng phụ <span>$750.99</span></div> --}}

                                <div class="checkout__order__total">Tổng <span class="hui-total-price"></span></div>
                                <button type="submit" class="site-btn">ĐẶT HÀNG</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
@push('scripts')
    <script>

// var number = Number($(ele).text().replace(/[^0-9-]+/g,""));
        'use strict';
        (function ($) {
            $('.hui-payment-method-item').each(function (index, ele) {
                $(ele).on('click', function( e ) {

                    $(this).addClass('active');
                    let self = this;

                    $('.hui-payment-method-item').each( function (index, ele) {
                        if(ele !== self){
                            $(this).removeClass('active');
                        }
                    })
                })
            });

            let total = 0;
            $('.cart-total').each( function (index, ele) {
                let price = $(ele).data('price');
                total += price;
                $(ele).text(formatCurrency(price));
            });

            $('.hui-total-price').text(formatCurrency(total));

            console.log($('#checkoutForm').serialize());
        })(jQuery);
    </script>
@endpush