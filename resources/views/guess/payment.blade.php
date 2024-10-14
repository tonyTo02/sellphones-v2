@extends('layout.guess')
@section('content')
@push('css')
@endpush
<div class="container mt-5" style="min-height: 450px">
    <form action="{{ route('stripe.payment.process', [$object->id, $object->total]) }}" method="POST" id="payment-form">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="amount">Tổng số tiền phải thanh toán</label>
                        <input type="text" name="amount" class="form-control" value="{{$object->total}}" readonly>
                    </div>
                </div>
                <div class="col">
                    <label for="card-element" class="form-label">Thông tin thẻ</label>
                    <div id="card-element" class="form-control">
                        <!-- Stripe sẽ render thông tin thẻ tại đây -->
                    </div>
                </div>
            </div>
            <div id="card-errors" role="alert" class="form-alert mt-1"></div>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Thanh toán</button>
    </form>
</div>
@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
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