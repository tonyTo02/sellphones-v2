@extends('layout.guess')
@section('content')
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
@endpush
@if (session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
@endif
<section class="product-details">
    <h2 class="text-center">Chi tiết sản phẩm</h2>
    <div class="product-carousel">
        <div class="product-item">
            <div class="row border">
                <div class="col-md-6 text-center">
                    <img src="https://tse2.mm.bing.net/th?id=OIP.fnaCAQ0Ah3NQ3kMtUpO1wwHaE8&pid=Api&P=0&h=220"
                        class="img-fluid" alt="Phone Details">
                </div>
                <div class="col-md-6">
                    <h3>Điện thoại 1</h3>
                    <p>Giá: $500</p>
                    <p>Mô tả: Đây là một chiếc điện thoại tuyệt vời với các tính năng hiện đại.</p>
                    <button class="btn btn-success">Thêm vào giỏ hàng</button>
                </div>
            </div>
        </div>
        <div class="product-item">
            <div class="row border">
                <div class="col-md-6 text-center">
                    <img src="https://tse2.mm.bing.net/th?id=OIP.fnaCAQ0Ah3NQ3kMtUpO1wwHaE8&pid=Api&P=0&h=220"
                        class="img-fluid" alt="Phone 2 Details">
                </div>
                <div class="col-md-6">
                    <h3>Điện thoại 2</h3>
                    <p>Giá: $600</p>
                    <p>Mô tả: Đây là một chiếc điện thoại tuyệt vời với các tính năng hiện đại.</p>
                    <button class="btn btn-success">Thêm vào giỏ hàng</button>
                </div>
            </div>
        </div>
        <!-- Thêm các sản phẩm khác tương tự -->
    </div>
</section>
<!-- Featured Products -->
<section class="featured-products mb-4">

    <h2 class="text-center">Sản phẩm nổi bật</h2>
    <div class="row">
        @foreach ($data as $product)
            <div class="col-md-4 mb-4">
                <div class="card border">
                    <img src="https://tse2.mm.bing.net/th?id=OIP.fnaCAQ0Ah3NQ3kMtUpO1wwHaE8&pid=Api&P=0&h=220"
                        class="card-img-top" alt="Anh san pham">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{$product->price}}</p>
                        <form action="{{route('guess.add.cart', $product->id)}}" method="post">
                            @csrf
                            <button href="" class="btn btn-primary add-to-cart">Mua ngay</button>
                            <a href="{{route('product.detail', $product->id)}}" class="btn btn-success view-detail">Xem chi
                                tiết</a>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach     

        {{$data->links('pagination')}}
        <!-- Thêm các sản phẩm khác tương tự -->
    </div>
</section>

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.product-carousel').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev">Previous</button>',
                nextArrow: '<button type="button" class="slick-next">Next</button>',
            });
        }); 
    </script>
@endpush
@endsection