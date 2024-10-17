@extends('layout.guess')
@section('content')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .swiper {
            width: 100%;
            height: 500px;
        }

        .swiper-product {
            width: 100%;
            height: 400px;
        }

        .same-product {
            background-color: #f3f3f3;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush
@if (session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
@endif
<div class="container mt-5" style="min-height: 450px">
    <div class="detail-product">
        <div class="row">
            <div class="col-md-6">
                <div class="swiper-container swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide text-center">
                            <img src="{{asset('storage') . '/' . $data->image}}" width="400px" height="500px"
                                alt="Phone Details">
                        </div>
                        @foreach ($images as $image)
                            <div class="swiper-slide text-center">
                                <img src="{{asset('storage') . '/' . $image->image_path}}" width="400px" height="500px"
                                    alt="Phone Details">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev swiper-detail-product-prev"></div>
                    <div class="swiper-button-next swiper-detail-product-next"></div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{route('guess.add.cart.detail', $data->id)}}" method="post">
                    <div class="row">
                        <h4 class="text-danger">{{$data->name}}</h4>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            Giá tiền:
                        </div>
                        <div class="col">
                            <h4 class="text-danger">${{sprintf("%.2f", $data->price / 100)}}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 mt-1">
                            Số lượng:
                        </div>
                        <div class="col-2">
                            <input type="number" class="form-control" name="quantity" min="1" max="9" value="1">
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="text-danger">{{$data->description}}</h4>
                    </div>

                    <div class="row text-end">
                        <div class="col">
                        </div>
                        <div class="col-4">
                            @csrf
                            <button class="btn btn-success add-to-cart">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="other-product mt-5">
        <h2 class="text-center text-danger">Các Sản Phẩm Liên Quan</h2>
        <div class="row">
            <div class="swiper-product">
                <div class="swiper-wrapper">
                    @foreach ($other_product as $product)
                        <div class="swiper-slide col-3 same-product me-2">
                            <div class="card border">
                                <img src="{{asset('storage') . '/' . $product->image}}" alt="Product">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{$product->name}}</h5>
                                    <p class="card-text">${{sprintf("%.2f", $product->price / 100)}}</p>
                                    <a href="{{route('guest.product.detail', $product->id)}}"
                                        class="btn btn-success view-detail">Xem chi
                                        tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>
@push('js')
    <script type="module">
        import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false,
            navigation: {
                nextEl: '.swiper-detail-product-next',
                prevEl: '.swiper-detail-product-prev',
            },
        })
        const swiperProduct = new Swiper('.swiper-product', {
            direction: 'horizontal',
            loop: false,
            slidesPerView: 5,
        })
    </script>

@endpush
@endsection