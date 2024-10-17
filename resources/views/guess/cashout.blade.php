@extends('layout.guess')
@section('content')
@push('css')

@endpush
@if (session()->get('message'))
    <h1 class="text-center text-danger">
        {{session()->get('message')}}
    </h1>
@endif
<div class="container mt-5 border text-center" style="min-height: 450px">
    <form action="{{route('cashout.process')}}" method="post" id="payment-form">
        @csrf
        <input type="number" name="total" class="cart-total-input form-control" hidden>
        <input type="text" name="status" hidden value="1">
        @auth('customer')
            <div class="row">
                <div class="col-6 justify-content-center text-center border me-1">
                    <input type="text" name="customer_id" class="form-control"
                        value="{{Auth::guard('customer')->user()->id}}" hidden>
                    <input type="text" name="gender" value="{{Auth::guard('customer')->user()->gender}}" hidden>
                    <input type="text" name="dob" value="{{Auth::guard('customer')->user()->dob}}" hidden>
                    <input type="text" name="password" value="{{Auth::guard('customer')->user()->password}}" hidden>
                    <!-- Customer -->
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="name" class="form-label mt-2">Name</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <input type="text" name="name" class="form-control" placeholder="Customer name"
                                value="{{Auth::guard('customer')->user()->name}}">
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="email" class="form-label mt-2">Email</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                value="{{Auth::guard('customer')->user()->email}}">
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="address" class="form-label mt-2">Address</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <input type="text" name="address" class="form-control" placeholder="Address"
                                value="{{Auth::guard('customer')->user()->address}}">
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-2 text-center p-1 mt-2 mb-2 align-self-center">
                            <label for="phone_number" class="form-label mt-2">Phone</label>
                        </div>
                        <div class="col-9 text-center p-1 mt-2 mb-2">
                            <input type="text" name="phone_number" class="form-control" placeholder="Phone number"
                                value="{{Auth::guard('customer')->user()->phone_number}}">
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
                                <img src="{{asset('storage') . '/' . $item['image']}}" alt="" width="50px" height="50px">
                            </div>
                            <div class="col">
                                <h6>{{$item['name']}}</h6>
                            </div>
                            <div class="col-1">
                                <h6>{{$item['quantity']}}</h6>
                            </div>
                            <div class="col-2">
                                <h5>${{sprintf("%.2f", ($item['price'] * $item['quantity']) / 100)}}</h5>
                                <input type="number" value="{{$item['price'] * $item['quantity']}}" class="total-temp" hidden>
                            </div>
                        </div>
                    @endforeach
                    <div class="row grand-total">
                        <span>Số tiền phải thanh toán là:
                            <h5 class="cart-total text-danger"></h5>
                        </span>
                    </div>
                    <div class="row card-infor">
                        <div class="col mt-2 p-2">
                            <label for="card-element" class="form-label">Thông tin thẻ</label>
                            <div id="card-element" class="form-control">
                                <!-- Stripe sẽ render thông tin thẻ tại đây -->
                            </div>
                        </div>
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
    </form>
</div>
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function () {
            updateTotalCart();
            function updateTotalCart() {
                let cartTotal = 0;
                $('.total-temp').each(function () {
                    let total = parseFloat($(this).val());
                    cartTotal += total;
                });
                $('.cart-total-input').val(cartTotal);
                console.log(cartTotal);
                let formatted = (parseFloat(cartTotal) / 100).toFixed(2);
                $('.cart-total').text('$' + formatted);
            }
        })
        // Cấu hình Stripe với Publishable key từ .env
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();

        // Tạo phần tử nhập thẻ của Stripe
        const card = elements.create('card');
        card.mount('#card-element');

        // Xử lý lỗi nhập thẻ
        card.on('change', function (event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Submit form thanh toán
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    // Hiển thị lỗi nếu có
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Gửi token tới server
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Thêm token vào form và gửi tới server
            const form = document.getElementById('payment-form');
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Gửi form
            form.submit();
        }
    </script>
@endpush
@endsection