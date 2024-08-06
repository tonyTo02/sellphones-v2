@extends('layout.master')
@section('content')
<h1>This Is Edit Form</h1>
<form action="{{route('bill.update', $each->id)}}" method="post" class="form">
    @csrf
    @method('PUT')
    <input type="text" hidden name="customer_id" value="{{$each->customer_id}}">
    <div class="group-input">
        <label for="customer_name" class="form-label">Tên khách hàng</label>
        <input type="text" name="customer_name" class="form-control" value="{{$each->name}}">
    </div>
    <div class="group-input">
        <label for="order_time" class="form-label">Thời gian đặt hàng</label>
        <input type="datetime" name="order_time" class="form-control" value="{{$each->order_time}}" readonly>
    </div>
    <div class="group-input">
        <label for="customer_phone_number" class="form-label">Số điện thoại</label>
        <input type="text" name="customer_phone_number" class="form-control" value="{{$each->phone_number}}">
    </div>
    <div class="group-input">
        <label for="note" class="form-label">Chú thích</label>
        <input type="text" name="note" class="form-control" value="{{$each->note}}">
    </div>
    <div class="group-input">
        <label for="customer_address" class="form-label">Địa chỉ giao hàng</label>
        <input type="text" name="customer_address" class="form-control" value="{{$each->address}}">
    </div>
    <div class="group-input">
        <label for="status" class="form-label">Trạng thái đơn hàng</label>
        <select name="status" class="form-control">
            @foreach ($billStatus as $option => $value)
                @if ($each->status === $value)
                    <option value="{{$value}}" selected>{{$option}}</option>
                @else
                    <option value="{{$value}}">{{$option}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="group-input">
        <label for="total" class="form-label">Tổng tiền</label>
        <input type="text" name="total" class="form-control" value="{{$each->total}}" readonly>
    </div>
    <div class="group-input">
        <br>
        <button class="btn btn-success">Save</button>
    </div>
</form>
@endsection