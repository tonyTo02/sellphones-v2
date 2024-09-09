@extends('layout.master')
@push('css')

@endpush
@section('content')
<h1>Day la trang chu cua he thong quan ly website</h1>
<a href="{{route('admin.create')}}" class="btn btn-primary">+ Create New</a>
@guest
    <a href="{{route('admin.login')}}" class="btn">Dang nhap</a>
@endguest
@auth
    <h1>Xin chao {{Auth::user()->name}}</h1>
@endauth
@endsection