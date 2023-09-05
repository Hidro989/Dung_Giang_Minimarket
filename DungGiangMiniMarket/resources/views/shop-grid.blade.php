@extends('layouts.app')
@section('title', 'Cửa hàng')
@section('content')
        <!-- Hero Section Begin -->
        @include('includes.hero')
       
        <!-- Hero Section End -->
    
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>Organi Shop</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.html">Home</a>
                                <span>Shop</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->
    
        <!-- Product Section Begin -->
        <section class="product spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-5">
                        <div class="sidebar">
                            <div class="sidebar__item">
                                <h4>Danh mục</h4>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a href="#">{{ $category->name}} </a></li>
                                    @endforeach
                                    <li><a href="#">Rau củ</a></li>
                                    <li><a href="#">Trái cây</a></li>
                                    <li><a href="#">Nột thất</a></li>
                                    <li><a href="#">Công nghệ</a></li>
                                    <li><a href="#">Nước ngọt</a></li>
                                </ul>
                            </div>
                            <div class="sidebar__item">
                                <h4>Giá</h4>
                                <div class="price-range-wrap">
                                    <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                        data-min="10000" data-max="500000">
                                        <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    </div>
                                    <div class="range-slider">
                                        <div class="price-input">
                                            <input type="text" id="minamount">
                                            <input type="text" id="maxamount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar__item">
                                <div class="latest-product__text">
                                    <h4>Sản phẩm mới</h4>
                                    <div class="latest-product__slider owl-carousel">
                                        <div class="latest-prdouct__slider__item">
                                            @for($i = 0 ; $i < 3 ; $i ++)
                                                @if(isset($lastProducts[$i]))
                                                <a href="{{route('product.show',$lastProducts[$i]->id)}}" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="{{ url($lastProducts[$i]->featured_image)}}" alt="">
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
                                                <a href="{{route('product.show',$lastProducts[$i]->id)}}" class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="{{ url($lastProducts[$i]->featured_image)}}" alt="">
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
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-7">
                        <div class="filter__item">
                            <div class="row">
                                <div class="col-lg-4 col-md-5">
                                    <div class="filter__sort">
                                        <span>Sắp xếp bởi</span>
                                        <select onchange="sortProduct(this)">
                                            <option value="">Lựa chọn</option>
                                            <option value="price">Giá (Tăng dần)</option>
                                            <option value="name">Tên (A-Z)</option>
                                            <option value="price_desc">Giá (Giảm dần)</option>
                                            <option value="name_desc">Tên (Z-A)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="filter__found">
                                        <h6><span>{{ count($products)}}</span>sản phẩm được tìm thấy.</h6>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3">
                                    <div class="filter__option">
                                        <span class="icon_grid-2x2"></span>
                                        <span class="icon_ul"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="product-list">
                            @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6 product-item" >
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{ url($product->featured_image)}}">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="{{route('product.show', $product->id)}}">{{ $product->name}}</a></h6>
                                        <h5>{{ $product->unit_price}}</h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="product__pagination d-flex justify-content-end">
                            {{ $products->links('pagination') }}
                            {{-- <a href="#">1</a>
                            <a href="#">2</a>
                            <a href="#">3</a>
                            <a href="#"><i class="fa fa-long-arrow-right"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        var items = Array.from(document.getElementsByClassName('product-item'))
        var productList = document.getElementById('product-list')
        function sortProduct(element){
            switch(element.value){
                case 'price':
                    items.sort((a, b) => parseInt(b.querySelector('h5').innerText) - parseInt(a.querySelector('h5').innerText))
                    productList.innerHTML = ''
                    items.forEach(item => productList.appendChild(item))
                    break
                case 'price_desc':
                    items.sort((a, b) => parseInt(a.querySelector('h5').innerText) - parseInt(b.querySelector('h5').innerText))
                    productList.innerHTML = ''
                    items.forEach(item => productList.appendChild(item))
                    break
                case 'name':
                    items.sort((a, b) => a.querySelector('h6').innerText.localeCompare(b.querySelector('h6').innerText))
                    productList.innerHTML = ''
                    items.forEach(item => productList.appendChild(item))
                    break
                case 'name_desc':
                    items.sort((a, b) => b.querySelector('h6').innerText.localeCompare(a.querySelector('h6').innerText))
                    productList.innerHTML = ''
                    items.forEach(item => productList.appendChild(item))
                    break
            }
        }
    </script>
@endpush