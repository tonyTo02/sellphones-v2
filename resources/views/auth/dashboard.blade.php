@extends('layout.guess')
@section('content')
@push('css')
    <style>

    </style>
@endpush
<h1>Đây là trang thông tin người dùng</h1>
<div class="container justify-content-center text-center">
    <div class="row">
        <h1>Đây sẽ là ảnh đại diện</h1>
    </div>
    <div class="row">
        <div class="col border">
            Đây là thông tin người dùng
        </div>
        <div class="col border">
            Đây là thông tin các đơn hàng mà người đùng đặt
        </div>

    </div>
</div>
@push('js')

@endpush
@endsection