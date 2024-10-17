@extends('layout.guess')
@section('content')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush
@if (session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
@endif
<section class="slideshow mb-4">
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
                <div class="swiper-slide">
                    <img src="{{asset('storage') . '/' . $image->image_path}}" width="100%" height="490px"
                        alt="Phone Details">
                </div>
            @endforeach
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
<!-- Featured Products -->
<section class="featured-products mb-4">
    <h2 class="text-center">Sản phẩm nổi bật</h2>
    <div class="row">
        @foreach ($data as $product)
            <div class="col-md-4 mb-4">
                <div class="card border">
                    <img src="{{asset('storage') . '/' . $product->image}}" class="card-img-top" alt="Anh san pham">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">${{sprintf("%.2f", $product->price / 100)}}</p>
                        <form action="{{route('guess.add.cart', $product->id)}}" method="post">
                            @csrf
                            <button href="" class="btn btn-primary add-to-cart">Mua ngay</button>
                            <a href="{{route('guest.product.detail', $product->id)}}"
                                class="btn btn-success view-detail">Xem chi
                                tiết</a>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        {{$data->links('pagination')}}
    </div>
</section>

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="module">
        import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 3000,  // Thời gian giữa mỗi lần tự động chuyển slide (tính bằng milliseconds)
                disableOnInteraction: false,
            }
        })
    </script>
@endpush
@endsection