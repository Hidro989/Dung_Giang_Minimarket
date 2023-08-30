@extends('layouts.app')
@section('title', 'Chi tiết sản phẩm')
@php
    use Illuminate\Support\Facades\Cookie;
    $user = Cookie::get('user');
    $user = isset($user) && (json_decode($user) !== null) ? json_decode($user) : null;
@endphp
@section('content')
    <style>
    body {
        padding-top: 70px;
    }
    .btn-grey{
        background-color:#D8D8D8;
        color:#FFF;
    }
    .rating-block{
        background-color:#FAFAFA;
        border:1px solid #EFEFEF;
        padding:15px 15px 20px 15px;
        border-radius:3px;
    }
    .bold{
        font-weight:700;
    }
    .padding-bottom-7{
        padding-bottom:7px;
    }

    .review-block{
        background-color:#FAFAFA;
        border:1px solid #EFEFEF;
        padding:15px;
        border-radius:3px;
        margin-bottom:15px;
    }
    .review-block-name{
        font-size:16px;
    }
    .review-block-date{
        font-size:12px;
    }
    .review-block-rate{
        font-size:13px;
        margin-bottom:15px;
    }
    .review-block-title{
        font-size:15px;
        font-weight:700;
        margin-bottom:10px;
    }
    .review-block-description{
        font-size:13px;
    }
    .login-link:hover{
        color:green;
    }
    </style>
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>Vegetable’s Package</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.html">Home</a>
                                <a href="./index.html">Vegetables</a>
                                <span>Vegetable’s Package</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
    
        <!-- Product Details Section Begin -->
        <section class="product-details spad">
            <div class="container">

                    <div class="row">
                        @if( count($product->variants) === 0)
                        {{-- Simple products --}}
                        <div class="col-lg-6 col-md-6">
                            <div class="product__details__pic">
                                <div class="product__details__pic__item">
                                    <img class="product__details__pic__item--large"
                                        src="{{url($product->featured_image)}}" alt="">
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="product__details__text">
                                <h3>{{ $product->name }}</h3>
                                <div class="product__details__rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <span>(18 reviews)</span>
                                </div>
                                <div class="product__details__price price_main"> {{ $product->unit_price }}</div>
                                <p>{{ $product->description}}</p>
                                <div class="product__details__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1">
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="primary-btn">Thêm vào giỏ hàng</a>
                                <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                                <ul>
                                    <li><b >Kho</b> <span class="total_stock">{{ $product->stock}}</span></li>
                                    <li><b>Cân nặng</b> <span>{{$product->weight}}</span> kg</li>
                                    <li><b>Chia sẻ</b>
                                        <div class="share">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-instagram"></i></a>
                                            <a href="#"><i class="fa fa-pinterest"></i></a>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                {{-- Variants products --}}
                @else
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="{{ url($product->featured_image) }}" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <img data-imgbigurl=" {{ url($product->featured_image)}}"
                            src="{{ url($product->featured_image) }}" alt="">
                            @foreach ($product->variants as $variant)
                            <img data-imgbigurl=" {{ url($variant->feature_image)}}"
                                src="{{ url($variant->feature_image) }}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{ $product->name }}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <div class="product__details__price"> {{ $product->unit_price }}</div>
                        <p>{{ $product->description}}</p>
                        @foreach($attributes as $index=>$attribute)
                                <div class="mb-3" style="display:flex; align-items:center">
                                    <label for="category_id" class="mr-3 mt-1">{{ $attribute->name }} : </label>
                                    <select id="category_id"  class="form-select form-control attributeType" aria-label="Default select example" name="attribute{{ $index }}" onchange="handleAttributeChange(this,{{$product->id}})">
                                        <option value=""> Chọn phân loại </option>
                                        @foreach ($attribute->value as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endforeach
                                <script type="text/javascript">
                                    var defaultPrice = document.querySelector('.product__details__price').innerText
                                    var defaultImg =  document.querySelector('.product__details__pic__item--large').src
                                    var attributes = {}
                                    function handleAttributeChange(element,id){
                                        let check = true
                                        attributes = {
                                            ...attributes,
                                            [element.name] : element.value
                                        }
                                        $('select.attributeType').each(function(){
                                            if( $(this).val() == ""){
                                                check = false
                                            }
                                        })
                                        if(check){
                                            getVariant(id)
                                        }else{
                                            $('.product__details__price').text(defaultPrice)
                                            $('.product__details__pic__item--large').attr('src',defaultImg)
                                            $('.total_stock').text('')
                                        }
                                    }
                                    function getVariant(id){
                                        $.ajax(
                                            {
                                            url: `/product/find?id=${id}`,
                                            method: 'GET',
                                            dataType: 'json',
                                            data: attributes,
                                            success: function ( data ){
                                                $('.product__details__pic__item--large').attr('src',data.feature_image)
                                                $('.product__details__price').text(data.unit_price)
                                                $('.total_stock').text(data.stock)
                                                }
                                            }
                                        )
                                    }
                                </script>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div>
                        </div>
                        <a href="#" class="primary-btn">Thêm vào giỏ hàng</a>
                        <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                        <ul>
                            <li><b>Kho :</b> <span class="total_stock">{{ $product->stock}}</span></li>
                            <li><b>Cân nặng :</b> <span>{{$product->weight}}</span> kg</li>
                            <li><b>Chia sẻ :</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
                        <div class="col-lg-12">
                            <div class="product__details__tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                            aria-selected="true">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                            aria-selected="false">Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                            aria-selected="false">Reviews <span>( {{ !empty($product->reviews) ? count($product->reviews) : '0'}} )</span></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            <h6>Products Infomation</h6>
                                            <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                                Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Vivamus
                                                suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam sit amet quam
                                                vehicula elementum sed sit amet dui. Donec rutrum congue leo eget malesuada.
                                                Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur arcu erat,
                                                accumsan id imperdiet et, porttitor at sem. Praesent sapien massa, convallis a
                                                pellentesque nec, egestas non nisi. Vestibulum ac diam sit amet quam vehicula
                                                elementum sed sit amet dui. Vestibulum ante ipsum primis in faucibus orci luctus
                                                et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam
                                                vel, ullamcorper sit amet ligula. Proin eget tortor risus.</p>
                                                <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                                ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                                elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                                porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                                nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.
                                                Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed
                                                porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum
                                                sed sit amet dui. Proin eget tortor risus.</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            <h6>Products Infomation</h6>
                                            <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                                Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                                Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                                sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                                eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                                Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                                sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                                diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                                ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                                Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                                Proin eget tortor risus.</p>
                                            <p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem
                                                ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet
                                                elit, eget tincidunt nibh pulvinar a. Cras ultricies ligula sed magna dictum
                                                porta. Cras ultricies ligula sed magna dictum porta. Sed porttitor lectus
                                                nibh. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                                        <div class="container d-flex flex-column mt-3">
                                             {{-- caculate rating stars --}}
                                             @php
                                             $star1 = 0;
                                             $star2 = 0;
                                             $star3 = 0;
                                             $star4 = 0;
                                             $star5 = 0;
                                             if(isset($product->reviews)){
                                                 foreach ($product->reviews as $review) {
                                                     switch($review->stars){
                                                         case '1':
                                                             $star1++;
                                                             break;
                                                         case '2':
                                                             $star2++;
                                                             break;
                                                         case '3':
                                                             $star3++;
                                                             break;
                                                         case '4':
                                                             $star4++;
                                                             break;
                                                         case '5':
                                                             $star5++;
                                                             break;
                                                     }
                                                 }
                                             }
                                             $totalReviews = $star1 + $star2 + $star3 + $star4 + $star5;
                                             $totalStars = $star1*1 + $star2*2 + $star3*3 + $star4*4 + $star5*5;
                                             if($totalReviews != 0){
                                                $starRate =  $totalStars / $totalReviews;
                                             }else{
                                                $starRate = 0;
                                             }
                                         @endphp
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-sm-3 mr-5">
                                                    <div class="rating-block">
                                                        <h4 class="mb-1">Đánh giá chung</h4>
                                                        @if($starRate != 0 )
                                                            <h2 class="bold padding-bottom-7 mb-2"> {{number_format($starRate,1)}} <small>/ 5</small></h2>
                                                            @for($i = 1 ; $i <= 5 ; $i++)
                                                                @if($i <= $starRate )
                                                                <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </button>
                                                                @else
                                                                <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </button>
                                                                @endif
                                                            @endfor
                                                        @else
                                                            <p class="bold padding-bottom-7 mb-2 mt-3 text-secondary">Chưa có đánh giá nào</small></p>
                                                            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </button>

                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 ml-5">
                                                   
                                                    <h4 class="mb-1">Chi tiết</h4>
                                                    <div class="pull-left">
                                                        <div class="pull-left" style="width:35px; line-height:1;">
                                                            <div style="height:9px; margin:5px 0;">5 <i class="fa fa-star"></i></div>
                                                        </div>
                                                        <div class="pull-left" style="width:180px;">
                                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 1000%">
                                                                <span class="sr-only">80% Complete (danger)</span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="pull-right" style="margin-left:10px;">{{ $star5}}</div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="pull-left" style="width:35px; line-height:1;">
                                                            <div style="height:9px; margin:5px 0;">4 <i class="fa fa-star"></i></div>
                                                        </div>
                                                        <div class="pull-left" style="width:180px;">
                                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                              <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: 80%">
                                                                <span class="sr-only">80% Complete (danger)</span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="pull-right" style="margin-left:10px;">{{ $star4}}</div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="pull-left" style="width:35px; line-height:1;">
                                                            <div style="height:9px; margin:5px 0;">3 <i class="fa fa-star"></i></div>
                                                        </div>
                                                        <div class="pull-left" style="width:180px;">
                                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: 60%">
                                                                <span class="sr-only">80% Complete (danger)</span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="pull-right" style="margin-left:10px;">{{ $star3}}</div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="pull-left" style="width:35px; line-height:1;">
                                                            <div style="height:9px; margin:5px 0;">2 <i class="fa fa-star"></i></div>
                                                        </div>
                                                        <div class="pull-left" style="width:180px;">
                                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: 40%">
                                                                <span class="sr-only">80% Complete (danger)</span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="pull-right" style="margin-left:10px;">{{ $star2 }}</div>
                                                    </div>
                                                    <div class="pull-left">
                                                        <div class="pull-left" style="width:35px; line-height:1;">
                                                            <div style="height:9px; margin:5px 0;">1 <i class="fa fa-star"></i></div>
                                                        </div>
                                                        <div class="pull-left" style="width:180px;">
                                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                              <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: 20%">
                                                                <span class="sr-only">80% Complete (danger)</span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="pull-right" style="margin-left:10px;">{{ $star1 }}</div>
                                                    </div>
                                                </div>			
                                            </div>			

                                            <div class="row d-flex justify-content-center">
                                              @if (!empty($reviews))
                                                @foreach($reviews as $review)
                                                <div class="col-sm-7">
                                                    <hr/>
                                                    <div class="review-block">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                {{-- <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded"> --}}
                                                                <div class="review-block-name"><b>{{ $review->user->username}}</b></div>
                                                                <div class="review-block-date">{{ $review->created_date}}<br/></div>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <div class="review-block-rate">
                                                                    @for ($i = 1 ; $i <=5 ; $i++)
                                                                        @if($i <= $review->stars)
                                                                        <i class="fa fa-star"></i>
                                                                        @else
                                                                        <i class="fa fa-star-o"></i>
                                                                        @endif                                                                    
                                                                    @endfor
                                                                    
                                                                </div>
                                                                {{-- <div class="review-block-title">Nội dung</div> --}}
                                                                <div class="review-block-description">{{ $review->content}}</div>
                                                            </div>
                                                        </div>
                                                        <hr/>
                                                    </div>
                                                </div>
                                                @endforeach
                                              @endif
                                            </div>
                                            @if(isset($user))
                                                <div class="row d-flex justify-content-center algin-items-end">
                                                    <form action="{{route('review.store')}}" class="form d-flex flex-column" method="POST">
                                                        @csrf
                                                        <div class="star-selection mt-2 mb-1">
                                                            <i class="fa fa-star" style="font-size:25px; cursor:pointer; margin-right:5px" data-star="1"></i>
                                                            <i class="fa fa-star" style="font-size:25px; cursor:pointer; margin-right:5px" data-star="2"></i>
                                                            <i class="fa fa-star" style="font-size:25px; cursor:pointer; margin-right:5px" data-star="3"></i>
                                                            <i class="fa fa-star" style="font-size:25px; cursor:pointer; margin-right:5px" data-star="4"></i>
                                                            <i class="fa fa-star-o" style="font-size:25px; cursor:pointer; margin-right:5px" data-star="5"></i>
                                                        </div>
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        <input type="hidden" name="rating_star" value="4">
                                                        <textarea name="rating_content" cols="50" rows="5" class="form-control" placeholder="Bạn nghĩ sao về sản phẩm ?" required></textarea>
                                                        <button class="btn btn-success ml-auto mt-2">Đánh giá</button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="row d-flex justify-content-center algin-items-end mt-3">
                                                    <a href="{{ route('login') }}" class="login-link"> Vui lòng đăng nhập để bình luận! </a>
                                                </div>
                                            @endif
                                            {{-- script --}}
                                            <script type="text/javascript">
                                                var stars = Array.from(document.querySelector('.star-selection').children);
                                                var starRating = document.querySelector('input[name=rating_star]');
                                                var mouseLeaveEvent = new Event("mouseleave", { bubbles: true, cancelable: true,});
                                                for(let [i,star] of stars.entries()){
                                                    star.addEventListener("mouseover", function() {
                                                        for (let j = 0; j <= i; j++) {
                                                            stars[j].classList.remove('fa-star-o');
                                                            stars[j].classList.add('fa-star');
                                                        }
                                                    });

                                                    star.addEventListener("mouseleave", function() {
                                                        for (let j = 4; j > starRating.value - 1; j--) {
                                                            stars[j].classList.add('fa-star-o');
                                                            stars[j].classList.remove('fa-star');
                                                        }
                                                        for (let j = 0; j < starRating.value - 1; j++) {
                                                            stars[j].classList.remove('fa-star-o');
                                                            stars[j].classList.add('fa-star');
                                                        }
                                                    });

                                                    star.addEventListener("click", function() {
                                                            starRating.value = star.dataset.star;
                                                            star.dispatchEvent(mouseLeaveEvent);
                                                    });
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
        <!-- Product Details Section End -->
    
        <!-- Related Product Section Begin -->
        <section class="related-product">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title related__product__title">
                            <h2>Các sản phẩm liên quan</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if( !empty($relatedProducts))
                        @foreach( $relatedProducts as $item)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ $item->featured_image}}">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="{{route('product.show',$item->id)}}">{{ $item->name}}</a></h6>
                                        <h5>{{ $item->unit_price }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- Related Product Section End -->
@endsection