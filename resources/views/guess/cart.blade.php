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
<div class="container mt-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>
    <div class="table-responsive">
        <form action="{{route('bill.store')}}" method="post">
            @csrf
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
                                    <img src="#" class="cart-item-image" alt="Phone 1">
                                    <span>{{$item['name']}}</span>
                                </div>
                            </td>
                            <td>
                                <input type="number" class="price form-control" value="{{$item['price']}}" readonly>
                            </td>
                            <td class="quantity">
                                <input type="number" class="form-control" value="{{$item['quantity']}}" min="1">
                            </td>
                            <td class="total">${{$item['price'] * $item['quantity']}}</td>
                            <td> <button class="btn btn-danger btn-remove">Xóa</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
    <div class="text-right">
        <h4>Tổng cộng: $1100</h4>
        <button class="btn btn-primary mt-3">Thanh toán</button>
    </div>
</div>
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.btn-remove').click(function () {
                var row = $(this).closest('tr');
                row.addClass('removing');
                setTimeout(function () {
                    row.remove();
                    // Cập nhật tổng cộng nếu cần
                    updateTotal();
                }, 500);
            });
            $('.quantity input').change(function () {
                const price = document.querySelectorAll('.price');

                console.log($(this).val());
                console.log(price[0]);
            })
        });
    </script>
@endpush
@endsection