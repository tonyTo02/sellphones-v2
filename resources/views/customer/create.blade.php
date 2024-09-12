@extends('layout.master')
@section('content')
<h1>This Is Create Form</h1>
<form action="{{route('customer.store')}}" method="post" enctype="multipart/form-data" class="form">
    @csrf
    <div class="group-input">
        <label for="name" class="form-label">Tên khách hàng</label>
        <input type="text" name="name" class="form-control">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="form-check mt-1 mb-1">
        <label for="gender" class="form-check-label">Male</label>
        <input type="radio" name="gender" class="form-check-input" checked value="0">
    </div>
    <div class="form-check mt-1 mb-1">
        <label for="gender" class="form-check-label">Female</label>
        <input type="radio" name="gender" class="form-check-input" value="1">
        @error('customer_name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="dob" class="form-label">Ngày sinh</label>
        <input type="date" name="dob" class="form-control">
        @error('dob')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" class="form-control">
        @error('email')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control">
        @error('password')
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
        <label for="phone_number" class="form-label">Số điện thoại</label>
        <input type="text" name="phone_number" class="form-control">
        @error('phone_number')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="avatar" class="form-label">Avatar</label>
        <input type="file" name="avatar" class="form-control">
        @error('avatar')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <br>
        <button class="btn btn-success">Create</button>
    </div>
</form>
@endsection