@extends('layout.master')
@section('content')
<h1>This Is Create Form</h1>
<form action="{{route('manufacturer.store')}}" method="post" enctype="multipart/form-data" class="form">
    @csrf
    <div class="group-input">
        <label for="name" class="form-label">Tên nhà sản xuất</label>
        <input type="text" name="name" class="form-control">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="address" class="form-label">Địa chỉ</label>
        <input type="text" name="address" class="form-control">
        @error('address')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="phone" class="form-label">Số điện thoại liên hệ</label>
        <input type="text" name="phone" class="form-control">
        @error('phone')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="image" class="form-label">Ảnh</label>
        <input type="file" name="image" class="form-control">
        @error('image')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>

    <div class="group-input mt-2">
        <button class="btn btn-success">Create</button>
    </div>
</form>
@endsection