@extends('layout.master')
@push('css')

@endpush
@section('content')
<h1>Day la trang chu cua he thong quan ly website</h1>
<a href="{{route('admin.create')}}">Tao moi</a>
<a href="{{route('admin.login')}}" class="btn">Dang nhap</a>
@auth
    <h1>Xin chao {{Auth::user()->name}}</h1>
@endauth
@endsection