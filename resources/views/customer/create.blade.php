@extends('layout.master')
@section('content')
<h1>This Is Create Form</h1>
<form action="{{route('customer.store')}}" method="post" class="form">
    @csrf
    <div class="group-input">
        <label for="name" class="form-label">Tên khách hàng</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="form-check mt-1 mb-1">
        <label for="gender" class="form-check-label">Male</label>
        <input type="radio" name="gender" class="form-check-input" checked value="0">
    </div>
    <div class="form-check mt-1 mb-1">
        <label for="gender" class="form-check-label">Female</label>
        <input type="radio" name="gender" class="form-check-input" value="1">
    </div>
    <div class="group-input">
        <label for="dob" class="form-label">Ngày sinh</label>
        <input type="date" name="dob" class="form-control">
    </div>
    <div class="group-input">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" class="form-control">
    </div>
    <div class="group-input">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="text" name="password" class="form-control">
    </div>
    <div class="group-input">
        <label for="address" class="form-label">Địa chỉ</label>
        <input type="text" name="address" class="form-control">
    </div>
    <div class="group-input">
        <label for="phone_number" class="form-label">Số điện thoại</label>
        <input type="text" name="phone_number" class="form-control">
    </div>
    <div class="group-input">
        <br>
        <button class="btn btn-success">Save</button>
    </div>
</form>
@endsection