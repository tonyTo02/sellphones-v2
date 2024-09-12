@extends('layout.guess')
@section('content')
@push('css')

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
                <div class="row">
                    <div class="col text-center">
                        <img src="{{asset('storage') . '/' . $data->image}}" width="400px" height="500px"
                            alt="Phone Details">
                    </div>
                </div>
                <div class="row">
                    @foreach ($images as $image)
                        <div class="col text-center">
                            <img src="{{asset('storage') . '/' . $image->image_path}}" width="200px" height="300px"
                                alt="Phone Details">
                        </div>
                    @endforeach
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
                            <h4 class="text-danger">{{$data->price}}</h4>
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
</div>

@push('js')

@endpush
@endsection