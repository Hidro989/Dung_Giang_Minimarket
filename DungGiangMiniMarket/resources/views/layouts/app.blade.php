@php
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\DB;
    $user = Cookie::get('user');
    $user = isset($user) && (json_decode($user) !== null) ? json_decode($user) : null;
    $list_orders = array();
    if($user !== null) {
        $number_cart_item = DB::table('cart_items')->where('user_id', $user->id)->count();

        $orders = DB::table('orders')->where('user_id', $user->id)->get();
    
        foreach($orders as $order) {

            $order_details = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('order_details.*', 'products.name', 'products.unit_price', 'products.featured_image')
            ->where('order_details.order_id', $order->id)
            ->get();

            $arr = json_decode(json_encode ( $order ) , true);
            foreach($order_details as $detail) {
                if( $order->id == $detail->order_id ){
                    $arr['order_details'][] = $detail;
                }
            }
            $list_orders[] = $arr;
        }
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" >

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style"  type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/dist/style.css')}}" type="text/css">

    @yield('styles')

    <style>
        body {
            font-family: 'Roboto',-apple-system, 'Segoe UI', Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
    </style>

</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="{{ route('/' )}}"><img src="{{ asset('assets/img/logo.png') }}" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>@isset($user)
                    {{$number_cart_item}}
                @endisset</span></a></li>
            </ul>
            <div class="header__cart__price">Vật phẩm: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            @if ( $user === null )
                <div class="header__top__right__auth">
                    <a href="{{ route('login')}}"><i class="fa fa-user"></i> Đăng nhập</a>
                    <a href="{{ route('register') }}"><i class="fa fa-user"></i> Đăng ký</a>
                </div>
            @else
            <div class="header__top__right_auth">
                <div class="dropdown">
                    <button class=" btn dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"> {{ $user->username }}</i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#userInfoModal">
                            <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Thông tin tài khoản
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#order">
                            <i class="fa fa-cart-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                            Đơn mua
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePass">
                            <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Đổi mật khẩu
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="fa fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Đăng xuất
                        </a>
                      </div>
                </div>
            </div>
            @endif
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.html">Trang chủ</a></li>
                <li><a href="/shop-grid">Cửa hàng</a></li>
                <li><a href="./contact.html">Liên hệ</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> dunggiang@gmail.com</li>
                <li>Giao hàng miễn phí cho tất cả đơn hàng 200k</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

       <!-- Header Section Begin -->
       <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> dunggiang@gmail.com</li>
                                <li>Giao hàng miễn phí cho tất cả đơn hàng 200k</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        @if ( $user === null )
                            <div class="header__top__right">
                                <div class="header__top__right__social">
                                    <a href="{{ route('register') }}"><i class="fa fa-user"></i> Đăng ký</a>
                                </div>
                                <div class="header__top__right__auth">
                                    <a href="{{ route('login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                                </div>
                            </div>
                        @else
                            <div class="header__top__right">
                                <div class="dropdown">
                                    <button class=" btn dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user"> {{ $user->username }}</i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#userInfoModal">
                                            <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Thông tin tài khoản
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#order">
                                            <i class="fa fa-cart-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Đơn mua
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePass">
                                            <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Đổi mật khẩu
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}">
                                            <i class="fa fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Đăng xuất
                                        </a>
                                      </div>
                                </div>
                            </div>
                        @endif
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="{{route('/')}}"><img src="{{ asset('assets/img/logo.png')}}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="{{ route('/') }}">Trang chủ</a></li>


                            <li><a href="./shop-grid.html">Cửa hàng</a></li>
                            <li><a href="{{url('/contact')}}">Liên hệ</a></li>


                        </ul>
                    </nav>
                </div>
                @if ( $user !== null )
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="{{ route('user.cart.index', $user->id ) }}"><i class="fa fa-shopping-bag"></i> <span>{{$number_cart_item}}</span></a></li>
                        </ul>
                        {{-- <div class="header__cart__price">Vật phẩm: <span>200k</span></div> --}}
                    </div>
                </div>
                @endif
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
        @yield('content')

        <!-- Footer Section Begin -->
        <footer class="footer spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer__about">
                            <div class="footer__about__logo">
                                <a href="{{route('/')}}"><img src="{{asset('assets/img/logo.png')}}" alt=""></a>
                            </div>
                            <ul>
                                <li>Địa chỉ: Đại Từ, Thái Nguyên</li>
                                <li>Số điện thoại: 0329 267 878</li>
                                <li>Email: dunggiang@gmail.com</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                        <div class="footer__widget">
                            <h6>Liên kết hữu ích</h6>
                            <ul>
                                <li><a href="#">Về chúng tôi</a></li>
                                <li><a href="#">Về cửa hàng của chúng tôi</a></li>
                                <li><a href="#">Mua sắm an toàn</a></li>
                                <li><a href="#">Thông tin giao hàng</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Sơ đồ trang web của chúng tôi</a></li>
                            </ul>
                            <ul>
                                <li><a href="#">Chúng ta là ai</a></li>
                                <li><a href="#">Dịch vụ của chúng tôi</a></li>
                                <li><a href="#">Dự án</a></li>
                                <li><a href="#">Liên hệ</a></li>
                                <li><a href="#">Sự đổi mới</a></li>
                                <li><a href="#">Lời chứng thức</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="footer__widget">
                            <h6>Tham gia Bản tin của chúng tôi ngay bây giờ</h6>
                            <p>Nhận thông tin cập nhật qua email về cửa hàng mới nhất của chúng tôi và các ưu đãi đặc biệt.</p>
                            <form action="#">
                                <input type="text" placeholder="Nhập email của bạn">
                                <button type="submit" class="site-btn">Đăng ký</button>
                            </form>
                            <div class="footer__widget__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer__copyright">
                            <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
      Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="#" target="_blank">HD Tech</a>
      <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
                            <div class="footer__copyright__payment"><img src="{{ asset('assets/img/payment-item.png') }}" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->


    <!-- Logout Modal-->


    @if ( isset($user) )
    <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Thông tin tài khoản</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateInfoForm" class="needs-validation">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group">
                        <label for="fullname">Tên người dùng</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập tên người dùng" value="{{ $user->fullname }}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="userBirth">Ngày sinh</label>
                        <input type="date" class="form-control" id="userBirth" name="date_of_birth" value="{{ $user->date_of_birth }}">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for="userGender">Giới tính</label>
                        <select id="userGender" class="form-control noNice" name="gender">
                          <option value="1" {{ $user->gender == 1 ? 'selected' : '' }}>Nam</option>
                          <option value="2" {{ $user->gender == 2 ? 'selected' : '' }}>Nữ</option>
                          <option value="3" {{ $user->gender == 3 ? 'selected' : '' }}>Khác</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label for="userAddress">Địa chỉ</label>
                        <input type="text" class="form-control" id="userAddress" name="address" placeholder="Nhập địa chỉ" value="{{ $user->address }}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="userPhone">Số điện thoại</label>
                        <input type="text" class="form-control" id="userPhone" name="phone" placeholder="Nhập số điện thoại" value="{{ $user->phone }}">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                <button class="btn btn-primary" type="button" id="btnUpdateInfo">Sửa</button>
            </div>
        </div>
    </div>
</div>
    
    <div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="changePassword"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePassword">Đổi mật khẩu</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="changePasswordForm">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="oldPass">Mật khẩu cũ</label>
                            <input type="password" class="form-control" id="oldPass" name="old_password" placeholder="Nhập mật khẩu cũ" value="" required>
                            <div class="invalid-feedback">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newPass">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPass" name="password" placeholder="Nhập mật khẩu mới" value="" required>
                            <div class="invalid-feedback">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirmation">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác thực mật khẩu" value="">
                            <div class="invalid-feedback">
                                
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <button class="btn btn-primary" type="button" id="btnChangePassword">Đổi mật khẩu</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="order" tabindex="-1" role="dialog" aria-labelledby="order-content"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="order-content">Đơn mua</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="overflow-x: auto;overflow-y: hidden;white-space: nowrap; flex-wrap:nowrap">
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

                            @foreach ($list_orders as $item)
                                @if ($item['status'] == 0)
                                    <div class="d-flex flex-column">
                                        @foreach ($item['order_details'] as $detail)
                                            <div class="d-flex p-2">
                                                <img src="{{$detail->featured_image}}" alt="" height="40" width="40">
                                                <div class="ml-2 w-100">
                                                    <p class="text-dark font-weight-bold w-100">{{$detail->name}}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <span>x {{$detail->quantity}}</span>
                                                        <span class="hui_price">{{$detail->unit_price}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                    <p>Số tiền phải trả: <span class="hui_price">{{$item['total_price']}}</span></p>
                                @endif
                            
                            
                            @endforeach
                            
                        </div>
                        <div class="tab-pane fade" id="delivering" role="tabpanel" aria-labelledby="delivering-tab">
                            @foreach ($list_orders as $item)
                                @if ($item['status'] == 1)
                                    <div class="d-flex flex-column">
                                        @foreach ($item['order_details'] as $detail)
                                            <div class="d-flex p-2">
                                                <img src="{{$detail->featured_image}}" alt="" height="40" width="40">
                                                <div class="ml-2 w-100">
                                                    <p class="text-dark font-weight-bold w-100">{{$detail->name}}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <span>x {{$detail->quantity}}</span>
                                                        <span class="hui_price">{{$detail->unit_price}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                    <p>Số tiền phải trả: <span class="hui_price">{{$item['total_price']}}</span></p>
                                @endif
                            
                            
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                            @foreach ($list_orders as $item)
                                @if ($item['status'] == 2)
                                    <div class="d-flex flex-column">
                                        @foreach ($item['order_details'] as $detail)
                                            <div class="d-flex p-2">
                                                <img src="{{$detail->featured_image}}" alt="" height="40" width="40">
                                                <div class="ml-2 w-100">
                                                    <p class="text-dark font-weight-bold w-100">{{$detail->name}}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <span>x {{$detail->quantity}}</span>
                                                        <span class="hui_price">{{$detail->unit_price}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                    <p>Số tiền phải trả: <span class="hui_price">{{$item['total_price']}}</span></p>
                                @endif
                            
                            
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
                            @foreach ($list_orders as $item)
                                @if ($item['status'] == 3)
                                    <div class="d-flex flex-column">
                                        @foreach ($item['order_details'] as $detail)
                                            <div class="d-flex p-2">
                                                <img src="{{$detail->featured_image}}" alt="" height="40" width="40">
                                                <div class="ml-2 w-100">
                                                    <p class="text-dark font-weight-bold w-100">{{$detail->name}}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <span>x {{$detail->quantity}}</span>
                                                        <span class="hui_price">{{$detail->unit_price}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                    <p>Số tiền phải trả: <span class="hui_price">{{$item['total_price']}}</span></p>
                                @endif
                            
                            
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                            @foreach ($list_orders as $item)
                                @if ($item['status'] == 4)
                                    <div class="d-flex flex-column">
                                        @foreach ($item['order_details'] as $detail)
                                            <div class="d-flex p-2">
                                                <img src="{{$detail->featured_image}}" alt="" height="40" width="40">
                                                <div class="ml-2 w-100">
                                                    <p class="text-dark font-weight-bold w-100">{{$detail->name}}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <span>x {{$detail->quantity}}</span>
                                                        <span class="hui_price">{{$detail->unit_price}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        @endforeach
                                    </div>
                                    <p>Số tiền phải trả: <span class="hui_price">{{$item['total_price']}}</span></p>
                                @endif
                            
                            
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/dist/main.js') }}"></script>
    @stack('scripts')
</body>
</html>