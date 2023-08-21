<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets\css\bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('assets\css\icon.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto',-apple-system, 'Segoe UI', Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .vh-100 {
            height: 100vh;
        }

        .btn-site,
        .bg-site {
          background: #7fad39;
        }

        .btn-site {
          color: #fff;
        }

        .divider:after,
        .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
        }
          .h-custom {
          height: calc(100% - 73px);
          }
            @media (max-width: 450px) {
            .h-custom {
            height: 100%;
          }
        }
    </style>
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5 d-flex justify-content-center">
              <img src="{{ asset('assets/img/logo.png') }}"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
              <form action="{{ route('handleLogin')}}" method="POST" novalidate>
                @csrf
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="text" id="form3Example3" name="username" class="form-control form-control-lg @error('username') is-invalid @enderror @if( session('error') ) is-invalid @endif"
                    placeholder="Nhập tên tài khoản" value="{{ old('username') }}"/>
                    @error('username')
                      <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
      
                <!-- Password input -->
                <div class="form-outline mb-3">
                  <input type="password" id="form3Example4" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror  @if( session('error') ) is-invalid @endif"
                    placeholder="Nhập mật khẩu" value="{{ old('password') }}"/>
                    @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                    @enderror

                    @if( session('error') )
                      <div class="invalid-feedback">
                        {{ session('error') }}
                      </div>
                    @endif

                </div>
      
                {{-- <div class="d-flex justify-content-between align-items-center">
                  <!-- Checkbox -->
                  <div class="form-check mb-0">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                    <label class="form-check-label" for="form2Example3">
                      Remember me
                    </label>
                  </div>
                  <a href="#!" class="text-body">Forgot password?</a>
                </div> --}}
      
                <div class="text-center text-lg-start mt-4 pt-2">
                  <button type="submit" class="btn btn-site btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng nhập</button>
                  <p class="small fw-bold mt-2 pt-1 mb-0">Bạn đã có tài khoản chưa? <a href="{{ route('register') }}"
                      class="link-danger">Đăng ký</a></p>
                </div>
                <div class="text-center text-lg-start mt-2">
                  <a href="{{ route('/') }}" class=" small fw-bold link-danger">Trang chủ</a>
                </div>
      
              </form>
            </div>
          </div>
        </div>
        <div
          class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-site">
          <!-- Copyright -->
          <div class="text-white mb-3 mb-md-0">
            Copyright DungGiangMarket © 2023. Đã đăng ký Bản quyền.
          </div>
          <!-- Copyright -->
      
          <!-- Right -->
          {{-- <div>
            <a href="#!" class="text-white me-4">
              <i class="fa fa-facebook-f"></i>
            </a>
            <a href="#!" class="text-white me-4">
              <i class="fa fa-twitter"></i>
            </a>
            <a href="#!" class="text-white me-4">
              <i class="fa fa-google"></i>
            </a>
            <a href="#!" class="text-white">
              <i class="fa fa-linkedin-in"></i>
            </a>
          </div> --}}
          <!-- Right -->
        </div>
      </section>
</body>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</html>