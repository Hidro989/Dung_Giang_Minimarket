<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng ký</title>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets\css\bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto',-apple-system, 'Segoe UI', Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .border-md {
            border-width: 2px;
        }

        body {
            min-height: 100vh;
        }

        .form-control:not(select) {
            padding: 10px 8px;
        }

        select.form-control {
            height: 52px;
            padding-left: 0.5rem;
        }

        .form-control::placeholder {
            color: #ccc;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .form-control:focus {
            box-shadow: none;
        }

        .btn-site,
        .bg-site {
            color: #fff;
            background: #7fad39;
        }

        .btn-site:hover {
            color: #fff
        }

    </style>
</head>
<body>
   <!-- Navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <!-- Navbar Brand -->
            <a href="{{ route('/') }}" class="navbar-brand">
                <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="150">
            </a>
        </div>
    </nav>
</header>


<div class="container">
    <div class="row py-5 mt-4 align-items-center">
        <!-- For Demo Purpose -->
        <div class="col-md-5 pr-lg-5 mb-5 mb-md-0 text-center">
            <img src="{{ asset('assets/img/raucuqua.jpg') }}" alt="" class="img-fluid mb-3 d-none d-md-block">
            <h1>Tạo tài khoản</h1>
        </div>

        <!-- Registeration Form -->
        <div class="col-md-7 col-lg-6 ml-auto">
            <form action="{{ route('handleRegister')  }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">

                    <!-- Name -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-user text-muted"></i>
                            </span>
                        </div>
                        <input id="fullName" type="text" name="fullname" placeholder="Họ và tên" class="form-control @error('fullname') is-invalid @enderror bg-white border-left-0 border-md" value="{{ old('fullname') }}">
                        @error('fullname')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- User Name -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-user-secret text-muted"></i>
                            </span>
                        </div>
                        <input id="username" type="text" name="username" placeholder="Tên tài khoản" class="form-control @error('username') is-invalid @enderror bg-white border-left-0 border-md" value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-phone-square text-muted"></i>
                            </span>
                        </div>
                        <input id="phoneNumber" type="tel" name="phone" placeholder="Số điện thoại" class="form-control @error('phone') is-invalid @enderror bg-white border-md border-left-0 pl-3" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-birthday-cake text-muted"></i>
                            </span>
                        </div>
                        <input id="dateOfBirth" type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror bg-white border-md border-left-0 pl-3" value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <!-- Gender -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-black-tie text-muted"></i>
                            </span>
                        </div>
                        <select id="gender" name="gender" class="form-control  @error('gender') is-invalid @enderror custom-select bg-white border-left-0 border-md">
                            <option value="">Giới tính</option>
                            <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>Nam</option>
                            <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>Nữ</option>
                            <option value="3" {{ old('gender') == 3 ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-address-book text-muted"></i>
                            </span>
                        </div>
                        <input id="address" type="text" name="address" class="form-control @error('address') is-invalid @enderror bg-white border-md border-left-0 pl-3" value="{{ old('address') }}" placeholder="Địa chỉ">
                        @error('address')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group col-lg-6 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-lock text-muted"></i>
                            </span>
                        </div>
                        <input id="password" type="password" name="password" placeholder="Mật khẩu" class="form-control @error('password') is-invalid @enderror bg-white border-left-0 border-md" value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="input-group col-lg-6 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-lock text-muted"></i>
                            </span>
                        </div>
                        <input id="passwordConfirmation" type="password" name="password_confirmation" placeholder="Xác thực mật khẩu" class="form-control @error('password') is-invalid @enderror bg-white border-left-0 border-md" value="{{ old('password_confirmation') }}">
                        @error('password')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if( session('error') )
                      <div class="alert alert-danger">
                        {{ session('error') }}
                      </div>
                    @endif
                    <!-- Submit Button -->
                    <div class="form-group col-lg-12 mx-auto mb-0">
                        <button class="btn btn-site btn-block py-2" type="submit">
                            <span>Tạo tài khoản của bạn</span>
                        </button>
                    </div>

                    <!-- Already Registered -->
                    <div class="text-center w-100">
                        <p class="text-muted font-weight-bold">Đã đăng ký? <a href="{{ route('login') }}" class="text-primary ml-2">Đăng nhập</a></p>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

</body>
    <script src="{{ asset('assets\js\jquery.min.js') }}"></script>
    <script>
        'use strict';

        jQuery( document ).ready( function( $ ) {

            $('input, select').on('focus', function () {
                    $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
            });

            $('input, select').on('blur', function () {
                    $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
            });

            function checkPassword() {
                let passwordConfirmation = $('#passwordConfirmation');
                let password = $('#password');
                console.log(passwordConfirmation.val());
                console.log(password.val());
            }
            checkPassword();
        });
    </script>
</html>