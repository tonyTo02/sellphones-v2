@extends('layout.guess')
@section('content')
@push('css')
    <style>
        .avatar {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid black;
            box-shadow: 0 0 0 1px black;
        }
    </style>
@endpush
<div class="container justify-content-center text-center">
    <div class="row">
        <div class="col border">
            <div class="row p-1 mb-2">
                <div class="col text-center">
                    <img src="{{asset('storage') . '/' . $customer->avatar}}" alt="Ảnh đại diện" class="avatar">
                </div>
            </div>
            <hr>
            <div class="row mt-2">
                <div class="col-3 mt-2">
                    <label for="name" class="form-label">Tên khách hàng</label>
                </div>
                <div class="col">
                    <input type="text" id="name" class="form-control" value="{{$customer->name}}" readonly>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3 mt-2">
                    <label for="gebder" class="form-label">Giới tính</label>
                </div>
                <div class="col">
                    <input type="text" id="gender" class="form-control" value="{{$customer->getGender()}}" readonly>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3 mt-2">
                    <label for="password" class="form-label">Mật khẩu</label>
                </div>
                <div class="col">
                    <input type="password" id="password" class="form-control" value="{{$customer->password}}" readonly>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3 mt-2">
                    <label for="address" class="form-label">Địa chỉ</label>
                </div>
                <div class="col">
                    <input type="text" id="address" class="form-control" value="{{$customer->address}}" readonly>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3 mt-2">
                    <label for="phone_number" class="form-label">Số điện thoại</label>
                </div>
                <div class="col">
                    <input type="text" id="phone_number" class="form-control" value="{{$customer->phone_number}}"
                        readonly>
                </div>
            </div>

        </div>
        <div class="col border">
            <div class="row">
                <div class="col">
                    <p>Đây là thông tin đơn hàng người dùng đã đặt</p>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <h6>#</h6>
                </div>
                <div class="col-3">
                    <h6>Thời gian đặt hàng</h6>
                </div>
                <div class="col">
                    <h6>Ghi chú</h6>
                </div>
                <div class="col-3">
                    <h6>Trạng thái đơn hàng</h6>
                </div>
                <div class="col-2">
                    <h6>Tổng tiền</h6>
                </div>
            </div>
            @foreach($order as $each)
                <div class="row mt-2 mb-1 p-2 border">
                    <div class="col-1">
                        <h6>{{$each->id}}</h6>
                    </div>
                    <div class="col-3">
                        <h6>{{$each->order_time}}</h6>
                    </div>
                    <div class="col">
                        <h6>{{$each->note}}</h6>
                    </div>
                    <div class="col-3">
                        <h6 class="status">{{$each->getBillStatus()}}</h6>
                    </div>
                    <div class="col-2">
                        <h6>${{sprintf("%.2f", $each->total / 100)}}</h6>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('h6.status').each(function () {
                let statusText = $(this).text();
                if (statusText == 'Đang giao hàng') {
                    $(this).addClass('text-danger');
                    $(this).addClass('fw-bold');
                } else if (statusText == 'Đang chờ xác nhận') {
                    $(this).addClass('text-warning');
                    $(this).addClass('fw-bold');
                } else if (statusText == 'Đã giao hàng') {
                    $(this).addClass('text-success');
                    $(this).addClass('fw-bold');
                }
            });
        });
    </script>
@endpush
@endsection