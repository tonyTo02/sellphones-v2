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
    <div class="product-carousel">
        @foreach ($images as $image)
            <div class="product-item">
                <div class="row border">
                    <img src="{{asset('storage') . '/' . $image->image_path}}" width="690px" height="490px"
                        alt="Phone Details">
                </div>
            </div>
        @endforeach
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
                        <p class="card-text">{{$product->price}}</p>
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