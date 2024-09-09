<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        header .logo h1 {
            margin: 0;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .featured-products h2,
        .product-details h2 {
            margin-bottom: 20px;
        }

        .card {
            border: none;
        }

        .card img {
            max-height: 400px;
            object-fit: cover;
        }

        .product-details .row {
            align-items: center;
        }

        footer p,
        footer ul {
            margin: 0;
        }

        footer ul {
            padding: 0;
        }

        footer ul li {
            display: inline;
            margin: 0 10px;
        }
    </style>
    @stack('css')
</head>

<body>
    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Sellphones</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('homepage')}}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Điện thoại</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Khuyến mãi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Về chúng tôi</a>
                        </li>
                    </ul>
                </div>
                <div class="search-bar flex-fill">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm điện thoại..." name="search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
                <div class="cart ms-4">
                    <a href="{{route('guess.cart')}}" class="text-white">Giỏ hàng</a>
                </div>
                <div class="cart ms-4">
                    @guest('customer')
                        <a class="btn btn-danger" href="{{route('auth.login')}}">Đăng nhập</a>
                        <a class="btn btn-danger" href="{{route('auth.register')}}">Đăng ký</a>
                    @endguest
                    @auth('customer')
                        <a href="{{route('auth.dashboard')}}" class="text-white">Hello
                            {{Auth::guard('customer')->user()->name}}</a>
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-link nav-link text-white bg-danger">Logout</button>
                        </form>
                    @endauth
                </div>

            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container mt-4">
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Sellphones. All rights reserved.</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#" class="text-white">Chính sách bảo mật</a></li>
                <li class="list-inline-item"><a href="#" class="text-white">Điều khoản sử dụng</a></li>
            </ul>
        </div>
    </footer>
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>