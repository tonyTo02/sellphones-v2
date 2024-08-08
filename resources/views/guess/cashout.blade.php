@extends('layout.guess')
@section('content')
@push('css')

@endpush
<div class="container mt-5 border text-center" style="min-height: 450px">
    <form action="{{route('cashout.process')}}" method="post">
        @csrf
        <input type="text" name="total" class="cart-total-input form-control" hidden>
        <input type="text" name="status" hidden value="1">
        <h1>Form thông tin</h1>
        @guest
            <h2>Vui lòng đăng nhập trước khi tiến hành thanh toán</h2>
            <a class="btn btn-danger" href="{{route('auth.login')}}">Đăng nhập</a>
            <a class="btn btn-danger" href="{{route('auth.register')}}">Đăng ký</a>
        @endguest
        @auth
            <div class="row">
                <div class="col-6 justify-content-center text-center border me-1">
                    <input type="text" name="customer_id" class="form-control" value="{{Auth::user()->id}}">
                    <input type="text" name="gender" value="{{Auth::user()->gender}}" hidden>
                    <input type="text" name="dob" value="{{Auth::user()->dob}}" hidden>
                    <input type="text" name="password" value="{{Auth::user()->password}}" hidden>
                    <!-- Customer -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="name" class="form-label mt-2">Name</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <input type="text" name="name" class="form-control" placeholder="Customer name"
                                value="{{Auth::user()->name}}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="email" class="form-label mt-2">Email</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                value="{{Auth::user()->email}}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="address" class="form-label mt-2">Address</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <input type="text" name="address" class="form-control" placeholder="Address"
                                value="{{Auth::user()->address}}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="phone_number" class="form-label mt-2">Phone</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <input type="text" name="phone_number" class="form-control" placeholder="Phone number"
                                value="{{Auth::user()->phone_number}}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="note" class="form-label mt-2">Note</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <textarea name="note" class="form-control">Ghi chú</textarea>
                        </div>
                    </div>
                    <!-- End Customer -->
                </div>
                <div class="col justify-content-center text-center border view-cart">
                    @foreach ($data as $item)
                        <div class="row mt-2 mb-1 p-2 border">
                            <div class="col-2">
                                <img src="#" alt="" width="50px" height="50px">
                            </div>
                            <div class="col">
                                <h6>{{$item['name']}}</h6>
                                <h6>{{$item['description']}}</h6>
                            </div>
                            <div class="col-1">
                                <h6>{{$item['quantity']}}</h6>
                            </div>
                            <div class="col-2 total">
                                <h5>${{$item['price'] * $item['quantity']}}</h5>
                            </div>
                        </div>
                    @endforeach
                    <div class="grand-total">
                        <span>Số tiền phải thanh toán là:
                            <h5 class="cart-total text-danger"></h5>
                        </span>
                        <span>

                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col p-1 mt-1">
                    <span class="text-danger">Lưu ý: </span>
                    <i>Vui lòng kiểm tra thông tin kỹ trước khi tiến hành thanh toán</i>
                </div>
                <div class="col align-self-end p-1 mt-1">
                    <button class="btn btn-success" type="submit">Thanh toán</button>
                </div>
            </div>
        @endauth
        <div class="row">
            <div class="col p-1 mt-1">
                @if ($errors)
                    <span class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
                @endif
            </div>
        </div>
    </form>

</div>
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            updateTotalCart();
            function updateTotalCart() {
                let cartTotal = 0;
                $('.total').each(function () {
                    let total = parseFloat($(this).text().replace('$', ''));
                    cartTotal += total;
                });
                $('.cart-total').text('$' + cartTotal.toFixed(2));
                $('.cart-total-input').val(cartTotal.toFixed(2));
            }
        })
    </script>
@endpush
@endsection