<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    @stack('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 1rem;
        }

        .sidebar {
            background: #343a40;
            color: white;
            padding: 1rem;
            min-height: 100vh;
        }

        .content {
            flex-grow: 1;
            padding: 1rem;
        }

        .footer {
            background: #6c757d;
            color: white;
            padding: 1rem;
        }
    </style>

</head>

<body>
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="#">Logo</a>
                <ul class="nav d-inline-flex">
                    <li class="nav-item p-1 m-1 me-1">Trang chủ</li>
                    <li class="nav-item p-1 m-1 me-1">Mat hang hot</li>
                    <li class="nav-item p-1 m-1 me-1">van van</li>
                    <li class="nav-item p-1 m-1 me-1">May may</li>
                    <li class="nav-item p-1 m-1 me-1">alo</li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('product.index')}}">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('customer.index')}}">Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('manufacturer.index')}}">Manufacturer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('bill.index')}}">Bill</a>
                    </li>
                </ul>
            </nav>
            <main class="col-md-9 col-lg-10 content">
                @yield('content')
            </main>
        </div>
    </div>
    <footer class="footer">
        <p>Footer</p>
    </footer>
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>