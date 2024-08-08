@extends('layout.guess')
@section('content')
@push('css')

@endpush
<div class="container mt-5" style="min-height: 450px">
    <h1>Đây là trang chi tiết sản phẩm</h1>
    Tên sản phẩm: {{$data->name}}
</div>
@push('js')

@endpush
@endsection