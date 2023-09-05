@extends('layouts.app')
@section('title', 'Trang chủ')
@section('content')
@php
    use Illuminate\Support\Facades\Cookie;
    $user = Cookie::get('user');
    $user = isset($user) && (json_decode($user) !== null) ? json_decode($user) : null;
   
@endphp
        <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Danh mục</span>
                        </div>
                        <ul>
                            @if( ! empty($categories) )
                                @foreach ($categories as $category)
                                    <li><a href="{{ route('product.shop_grid', $category->id) }}">{{$category->name}}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{ route('product.search') }}" method="GET">
                                <input type="text" placeholder="Bạn cần gì?" name="key">
                                <button type="submit" class="site-btn">TÌM KIẾM</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>0329 267 878</h5>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                    </div>
                    
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <div class="hero__item set-bg" data-setbg="{{ asset('assets/img/hero/banner.jpg')}}">
                                <div class="hero__text">
                                    <span>TRÁI CÂY TƯƠI</span>
                                    <h2>Rau quả <br />100% Organic</h2>
                                    <p>Nhận và giao hàng miễn phí có sẵn</p>
                                    <a href="#" class="primary-btn">MUA NGAY</a>
                                </div>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <div class="hero__item set-bg" data-setbg="{{ asset('assets/img/banner/banner-1.jpg')}}">
                                {{-- <div class="hero__text">
                                    <span>TRÁI CÂY TƯƠI</span>
                                    <h2>Rau quả <br />100% Organic</h2>
                                    <p>Nhận và giao hàng miễn phí có sẵn</p>
                                    <a href="#" class="primary-btn">MUA NGAY</a>
                                </div> --}}
                            </div>
                          </div>
                          <div class="carousel-item">
                            <div class="hero__item set-bg" data-setbg="{{ asset('assets/img/banner/banner-2.jpg')}}">
                                {{-- <div class="hero__text">
                                    <span>TRÁI CÂY TƯƠI</span>
                                    <h2>Rau quả <br />100% Organic</h2>
                                    <p>Nhận và giao hàng miễn phí có sẵn</p>
                                    <a href="#" class="primary-btn">MUA NGAY</a>
                                </div> --}}
                            </div>
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    @if( ! empty($categories) )
                            @foreach ($categories as $category)
                            <div class="col-lg-3">
                                <div class="categories__item set-bg" data-setbg="{{ asset($category->image) }}">
                                    <h5><a href="#">{{$category->name}}</a></h5>
                                </div>
                            </div>
                            @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Sản phẩm nổi bật</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            @if( ! empty($categories) )
                                @foreach ($categories as $category)
                                    <li data-filter=".{{ 'category'.$category->id }}">{{ $category->name}}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">

                @if( !empty($products))
                    @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix {{ 'category'.$product->category_id }} fresh-meat">
                        <div class="featured__item">
                            <div class="featured__item__pic set-bg" data-setbg="{{ url($product->featured_image) }}">
                                @if ( 0 === $product->is_variant)
                                    <ul class="featured__item__pic__hover" >
                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                        {{-- <li><a href="{{ route('user.cart.add', ['product_id' => $product->id]) }}"><i class="fa fa-shopping-cart"></i></a></li> --}}
                                        <li><a href="#" class="btnAddToCart" data-product-id="{{$product->id}}" data-user-id="{{isset($user) ? $user->id : -1}}"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                @endif
                            </div>
                            <div class="featured__item__text">
                                <h6><a href="{{ route('product.show', $product->id)}}">{{ $product->name }}</a></h6>
                                    <h5> {{ $product->unit_price }}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('assets/img/banner/banner-1.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('assets/img/banner/banner-2.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="latest-product__text">
                        <h4>Sản phẩm mới</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                            @for($i = 0 ; $i < 3 ; $i ++)
                                @if(isset($lastProducts[$i]))
                                    <a href="{{ route('product.show',$lastProducts[$i]->id)}}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{ url($lastProducts[$i]->featured_image) }}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>{{ $lastProducts[$i]->name}}</h6>
                                            <span>{{ $lastProducts[$i]->unit_price}}</span>
                                        </div>
                                    </a>
                                @endif
                            @endfor
                            </div>
                            <div class="latest-prdouct__slider__item">
                            @for($i = 3 ; $i < 6 ; $i ++)
                                @if(isset($lastProducts[$i]))
                                    <a href="{{ route('product.show',$lastProducts[$i]->id)}}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{ url($lastProducts[$i]->featured_image) }}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>{{ $lastProducts[$i]->name}}</h6>
                                            <span>{{ $lastProducts[$i]->unit_price}}</span>
                                        </div>
                                    </a>
                                @endif
                            @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="latest-product__text">
                        <h4>Ưa thích nhất</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                            @for($i = 0 ; $i < 3 ; $i ++)
                                @if(isset($ratestProducts[$i]))
                                    <a href="{{ route('product.show',$ratestProducts[$i]->id)}}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{ url($ratestProducts[$i]->featured_image) }}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>{{ $ratestProducts[$i]->name}}</h6>
                                            <span>{{ $ratestProducts[$i]->unit_price}}</span>
                                        </div>
                                    </a>
                                @endif
                            @endfor
                            </div>
                            <div class="latest-prdouct__slider__item">
                            @for($i = 3 ; $i < 6 ; $i ++)
                                @if(isset($ratestProducts[$i]))
                                    <a href="{{ route('product.show',$ratestProducts[$i]->id)}}" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="{{ url($ratestProducts[$i]->featured_image) }}" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6>{{ $ratestProducts[$i]->name}}</h6>
                                            <span>{{ $ratestProducts[$i]->unit_price}}</span>
                                        </div>
                                    </a>
                                @endif
                            @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->
@endsection

@push('scripts')
    
@endpush