@extends('layout.master')
@section('content')
<h1>This Is Create Form</h1>
<form action="{{route('manufacturer.update', $each->id)}}" method="post" class="form">
    @csrf
    @method('PUT')
    <div class="group-input">
        <label for="name" class="form-label">Tên nhà sản xuất</label>
        <input type="text" name="name" class="form-control" value="{{$each->name}}">
    </div>
    <div class="group-input">
        <label for="address" class="form-label">Địa chỉ</label>
        <input type="text" name="address" class="form-control" value="{{$each->address}}">
    </div>
    <div class="group-input">
        <label for="phone" class="form-label">Số điện thoại liên hệ</label>
        <input type="text" name="phone" class="form-control" value="{{$each->phone}}">
    </div>
    <div class="group-input">
        <label for="image" class="form-label">Ảnh</label>
        <input type="text" name="image" class="form-control" value="{{$each->image}}">
        <input type="file" name="new_image" class="form-control">
    </div>

    <div class="group-input mt-2">
        <button class="btn btn-success">Save</button>
    </div>
</form>
@endsection