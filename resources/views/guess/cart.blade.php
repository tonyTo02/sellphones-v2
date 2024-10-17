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
<form action="{{route('guest.pre.cashout')}}" method="post" id="form-quantity">
    @csrf
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
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>
                                <div class="cart-item">
                                    <img src="{{asset('storage') . '/' . $item['image']}}" class="cart-item-image">
                                    <span>{{$item['name']}}</span>
                                </div>
                            </td>
                            <td>
                                <h4>${{sprintf("%.2f", $item['price'] / 100)}}</h4>
                                <input type="number" class="price form-control" value="{{$item['price']}}" readonly hidden>
                            </td>
                            <td>
                                <input type="text" name="{{'old_quantity' . $key}}" class="old_quantity"
                                    value="{{$item['quantity']}}" hidden>
                                <input type="number" name="{{'new_quantity' . $key}}" class="new-quantity form-control"
                                    value="{{$item['quantity']}}" min="1" max="9">
                            </td>
                            <td class="total">${{sprintf("%.2f", ($item['quantity'] * $item['price']) / 100)}}</td>
                            <td>
                                <form action="{{route('guest.remove.cart', $key)}}" method="post" id="form-remove">
                                    @csrf
                                    <button action="{{route('guest.remove.cart', $key)}}" type="button"
                                        class="btn btn-danger btn-remove">Xóa</button>
                                </form>
                            </td>
                            <td>
                                <input type="text" class="key" value="{{$key}}" id="id-remove" hidden>
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
                            <button type="button" class="btn btn-primary" id="btn-cashout">Thanh Toán</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</form>

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            updateTotalCart();
            function updateTotal(row) {
                let price = parseFloat(row.find('.price').val());
                let quantity = parseInt(row.find('.new-quantity').val());
                let total = price * quantity;
                let formatted = (parseFloat(total) / 100).toFixed(2);
                row.find('.total').text('$' + formatted);
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
            $('.btn-remove').click(function (e) {
                let row = $(this).closest('tr');
                let actionUrl = $(this).attr('action');
                let csrfInput = row.find('input');
                let csrfToken = csrfInput[3].value;
                if (actionUrl) {
                    e.preventDefault();
                    $.ajax({
                        url: actionUrl,
                        method: 'POST',
                        data: { _token: csrfToken },
                        success: function (response) {
                            if (response.success) {
                                row.addClass('removing');
                                setTimeout(function () {
                                    row.remove();
                                    updateTotalCart(); // Gọi hàm cập nhật giỏ hàng
                                }, 500);
                            } else {
                                alert(response.message); // Thông báo lỗi nếu cần
                            }
                        },
                        error: function (err) {
                            console.log("Có lỗi xảy ra:", err); // Xử lý lỗi nếu submit thất bại
                        }
                    });
                }
            });
            $('.new-quantity').change(function () {
                var row = $(this).closest('tr');
                updateTotal(row);
            });
        });
        const formQuantity = document.getElementById('form-quantity');
        const btnCashOut = document.getElementById('btn-cashout');
        btnCashOut.addEventListener('click', (e) => {
            formQuantity.submit();
        })

    </script>
@endpush
@endsection