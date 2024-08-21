@extends('layout.guess')
@section('content')
@push('css')

@endpush
<div class="container mt-5" style="min-height: 450px">
    <div class="detail-product border">
        <div class="row text-center">
            <div class="col">
                <h1>Đây là chi tiết sản phẩm</h1>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <img src="{{asset('storage') . '/' . $data->image}}" width="400px" height="500px">
            </div>
            <div class="col">
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
                <div class="row">
                    <h4 class="text-danger">{{$data->manufacturer_id}}</h4>
                </div>
                <div class="row text-end">
                    <div class="col">
                    </div>
                    <div class="col-4">
                        <form action="{{route('guess.add.cart', $data->id)}}" method="post">
                            @csrf
                            <button class="btn btn-success add-to-cart">Thêm vào giỏ hàng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')

@endpush
@endsection