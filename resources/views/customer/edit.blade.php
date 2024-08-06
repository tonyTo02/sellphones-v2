@extends('layout.master')
@section('content')
<h1>This Is Edit Form</h1>
<form action="{{route('customer.update', $each->id)}}" method="post" class="form">
    @csrf
    @method('PUT')
    <div class="group-input">
        <label for="name" class="form-label">Tên khách hàng</label>
        <input type="text" name="name" class="form-control" value="{{$each->name}}">
    </div>
    <div class="form-check mt-1 mb-1">
        <label for="gender" class="form-check-label">Male</label>
        <input type="radio" name="gender" class="form-check-input" value="0" {{$each->gender === 0 ? 'checked' : ''}}>
    </div>
    <div class="form-check mt-1 mb-1">
        <label for="gender" class="form-check-label">Female</label>
        <input type="radio" name="gender" class="form-check-input" value="1" {{$each->gender === 1 ? 'checked' : ''}}>
    </div>
    <div class="group-input">
        <label for="dob" class="form-label">Ngày sinh</label>
        <input type="date" name="dob" class="form-control" value="{{$each->dob}}">
    </div>
    <div class="group-input">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" class="form-control" value="{{$each->email}}">
    </div>
    <div class="group-input">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="text" name="password" class="form-control" value="{{$each->password}}">
    </div>
    <div class="group-input">
        <label for="address" class="form-label">Địa chỉ</label>
        <input type="text" name="address" class="form-control" value="{{$each->address}}">
    </div>
    <div class="group-input">
        <label for="phone_number" class="form-label">Số điện thoại</label>
        <input type="text" name="phone_number" class="form-control" value="{{$each->phone_number}}">
    </div>
    <div class="group-input">
        <br>
        <button class="btn btn-success">Save</button>
    </div>
</form>
@endsection