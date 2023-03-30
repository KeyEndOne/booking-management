<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/app.js') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="header">
        <div class="header-item">
            <ul>
                <li>
                    <div class="header-logo">
                        <img src="{{ asset('/images/logo.svg')}}">
                    </div>
                </li>
                <li>
                    <a class="btn button" href="{{ route('clienthome' )}}">Trang chủ </a>
                </li>
                <li>
                    <a class="btn button" href="{{ route('about' )}}">Giới thiệu</a>
                </li>
                @guest

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="btn button nav-link" href="{{ route('register') }}">Đăng ký</a>
                </li>
                @endif
                @if (Route::has('login'))

                <li class="nav-item">
                    <a class="btn button nav-link" href="{{ route('login') }}">Đăng nhập</a>
                </li>
                @endif
                @else

                <li>
                    <a class="btn button" href="{{ route('searchtiket' )}}">Các vé đã đặt</a>
                </li>
                <li class="nav-item dropdown">

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                <li>
                    <a class="button btn" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        Hello {{ Auth::user()->name }}, Đăng xuất
                    </a>
                </li>

                @endguest
            </ul>
        </div>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
    </div>
    <div class="footer">
        <div style="font-size:large;font-weight:bold;color:#4D4D4D;margin-top :5px;">
            Công ty TNHH Thương Mại Dịch Vụ VeXeRe
        </div>
        <p>Địa chỉ đăng ký kinh doanh: 8C Chữ Đồng Tử, Phường 7, Quận Tân Bình, Thành Phố Hồ Chí Minh, Việt Nam</p>
        <p>Địa chỉ: Lầu 8 Tòa nhà CirCO, 222 Điện Biên Phủ, Quận 3, TP. Hồ Chí Minh, Việt Nam</p>
        <p>Giấy chứng nhận ĐKKD số 0315133726 do Sở KH và ĐT TP. Hồ Chí Minh cấp lần đầu ngày 27/6/2018</p>
        <p>Bản quyền © 2020 thuộc về VeXeRe.Com</p>
    </div>
</body>

</html>