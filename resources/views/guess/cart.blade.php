@extends('layout.guess')
@section('content')
@push('css')
    <style>
        .cart-item {
            display: flex;
            align-items: center;
            transition: opacity 0.5s ease-out;
        }

        .cart-item.removing {
            opacity: 0;
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
            transform: translateX(100%);
        }

        .cart-item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }
    </style>
@endpush
<div class="container mt-5" style="min-height: 450px">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Sản phẩm</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Tổng cộng</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>
                            <div class="cart-item">
                                <img src="{{asset('storage') . '/' . $item['image']}}" class="cart-item-image">
                                <span>{{$item['name']}}</span>
                            </div>
                        </td>
                        <td>
                            <input type="number" class="price form-control" value="{{$item['price']}}" readonly>
                        </td>
                        <td>
                            <input type="number" class="quantity form-control" value="{{$item['quantity']}}" min="1">
                        </td>
                        <td class="total">${{$item['quantity'] * $item['price']}}</td>
                        <td>
                            <button class="btn btn-danger btn-remove">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <h5>TỔNG TIỀN</h5>
                    </td>
                    <td>
                        <h4 class="cart-total"></h4>
                    </td>
                    <td>
                        <a href="{{route('guess.cash.out')}}" class="btn btn-primary">Thanh Toán</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            updateTotalCart();
            function updateTotal(row) {
                let price = parseFloat(row.find('.price').val());
                console.log("Gia: " + price);
                let quantity = parseInt(row.find('.quantity').val());
                console.log("quantity: " + quantity);
                let total = price * quantity;
                console.log('Tổng Tiền: ' + total);
                row.find('.total').text('$' + total.toFixed(2));
                updateTotalCart()
            }
            function updateTotalCart() {
                let cartTotal = 0;
                $('.total').each(function () {
                    let total = parseFloat($(this).text().replace('$', ''));
                    cartTotal += total;
                });
                $('.cart-total').text('$' + cartTotal.toFixed(2));
            }
            $('.btn-remove').click(function () {
                let row = $(this).closest('tr');
                row.addClass('removing');
                setTimeout(function () {
                    row.remove();
                    updateTotal();
                }, 500);
                updateTotalCart();
            });
            $('.quantity').change(function () {
                var row = $(this).closest('tr');
                updateTotal(row);
            });
        });
    </script>
@endpush
@endsection