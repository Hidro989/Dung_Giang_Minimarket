@php
    use Illuminate\Support\Facades\Cookie;

    $user = Cookie::get('user');
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
            <a href="#"><img src="{{ asset('assets/img/logo.png') }}" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">Vật phẩm: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            @if ( ! isset($user) || (json_decode($user) === null) )
                <div class="header__top__right__auth">
                    <a href="{{ route('login')}}"><i class="fa fa-user"></i> Đăng nhập</a>
                    <a href="{{ route('register') }}"><i class="fa fa-user"></i> Đăng ký</a>
                </div>
            @else
            <div class="header__top__right_auth">
                <div class="dropdown">
                    <button class=" btn dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"> {{ json_decode($user)->username }}</i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#userInfoModal">
                            <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Thông tin tài khoản
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
                <li><a href="./shop-grid.html">Cửa hàng</a></li>
                <li><a href="#">Trang</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.html">Shop Details</a></li>
                        <li><a href="{{ route('user.cart.index') }}">Giỏ hàng</a></li>
                        <li><a href="./checkout.html">Check Out</a></li>
                        <li><a href="./blog-details.html">Blog Details</a></li>
                    </ul>
                </li>
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
                        @if ( ! isset($user) || (json_decode($user) === null) )
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
                                        <i class="fa fa-user"> {{ json_decode($user)->username }}</i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#userInfoModal">
                                            <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Thông tin tài khoản
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
                        <a href="./index.html"><img src="{{ asset('assets/img/logo.png')}}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="./index.html">Trang chủ</a></li>
                            <li><a href="./shop-grid.html">Cửa hàng</a></li>
                            <li><a href="#">Trang</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="./shop-details.html">Shop Details</a></li>
                                    <li><a href="{{ route('user.cart.index') }}">Shoping Cart</a></li>
                                    <li><a href="./checkout.html">Check Out</a></li>
                                    <li><a href="./blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="./contact.html">Liên hệ</a></li>
                        </ul>
                    </nav>
                </div>
                @if ( isset($user) && (json_decode($user) !== null) )
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="{{ route('user.cart.index') }}"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                        </ul>
                        <div class="header__cart__price">Vật phẩm: <span>200k</span></div>
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
                                <a href="./index.html"><img src="img/logo.png" alt=""></a>
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

    @php
        $user = isset($user) && (json_decode($user) !== null) ? json_decode($user) : null;
    @endphp
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
                    <form action="">
                        <div class="form-group">
                            <label for="fullname">Tên người dùng</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập tên người dùng" value="{{ $user->fullname }}">
                        </div>
                        <div class="form-group">
                            <label for="userBirth">Ngày sinh</label>
                            <input type="date" class="form-control" id="userBirth" name="date_of_birth" value="{{ $user->date_of_birth }}">
                        </div>

                        <div class="form-group">
                            <label for="userGender">Giới tính</label>
                            <select id="userGender" class="wide form-control">
                              <option value="1" {{ $user->gender == 1 ? 'selected' : '' }}>Nam</option>
                              <option value="2" {{ $user->gender == 2 ? 'selected' : '' }}>Nữ</option>
                              <option value="3" {{ $user->gender == 3 ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="userAddress">Địa chỉ</label>
                            <input type="text" class="form-control" id="userAddress" name="address" placeholder="Nhập địa chỉ" value="{{ $user->address }}">
                        </div>
                        <div class="form-group">
                            <label for="userPhone">Số điện thoại</label>
                            <input type="text" class="form-control" id="userPhone" name="phone" placeholder="Nhập số điện thoại" value="{{ $user->phone }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Sửa</a>
                </div>
            </div>
        </div>
    </div>
    @endif

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
                    <form action="">
                        <div class="form-group">
                            <label for="oldPass">Mật khẩu cũ</label>
                            <input type="text" class="form-control" id="oldPass" name="oldpass" placeholder="Nhập mật khẩu cũ" value="">
                        </div>
                        <div class="form-group">
                            <label for="newPass">Địa chỉ</label>
                            <input type="text" class="form-control" id="newPass" name="password" placeholder="Nhập mật khẩu mới" value="">
                        </div>
                        <div class="form-group">
                            <label for="password-confirmation">Số điện thoại</label>
                            <input type="text" class="form-control" id="password-confirmation" name="password-confirmation" placeholder="Xác thực mật khẩu" value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Đổi mật khẩu</a>
                </div>
            </div>
        </div>
    </div>

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