@extends('layout.master')
@push('css')
    <style>
        .search-bar {
            width: 30%;
        }

        .detail-bill {
            cursor: pointer;
        }

        .close-button {
            background-color: #f0f0f0;

        }

        .detail-bill-alert {
            height: 500px;
            width: 500px;
            position: fixed;
            top: 0%;
            left: 50%;
            background-color: #f0f0f0;
            z-index: 99;
        }

        .blur {
            filter: blur(2px);
            opacity: 0.3;
        }

        .close-icon {
            cursor: pointer;
            color: red;
            position: absolute;
            right: 0;
        }
    </style>
@endpush
@section('content')
<h1>Đây là trang quản lý bill</h1>
<div class="d-flex justify-content-end">
    <div class="p-1"></div>
    <div class="p-1 search-bar">
        <input name="q" type="text" class="search form-control" placeholder="Search">
    </div>
</div>
<table class="table max-w-7xl mx-auto p-6 lg:p-8 text-center">
    <tr>
        <th>#</th>
        <th>Tên khách đặt hàng</th>
        <th>Ngày đặt</th>
        <th>Số điện thoại</th>
        <th>Chú thích</th>
        <th>Địa chỉ giao hàng</th>
        <th>Trạng thái đơn hàng</th>
        <th>Tổng tiền</th>
        <th>Chi tiết đơn hàng</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    @foreach ($data as $each)
        <tr>
            <td class="bill">{{$each->id}}</td>
            <td>{{$each->name}}</td>
            <td>{{$each->order_time}}</td>
            <td>{{$each->phone_number}}</td>
            <td>{{$each->note}}</td>
            <td>{{$each->address}}</td>
            <td class="status">{{$each->getBillStatus()}}</td>
            <td>${{$each->total}}</td>
            <td>
                <a class="detail-bill">Chi Tiết</a>
            </td>
            <td>
                <a href="{{route('bill.edit', $each->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{route('bill.destroy', $each->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
<div class="mt-8">
    {{$data->links('pagination')}}
</div>
<div class="detail-bill-alert p-1 m-1" hidden>
    <div class="close-button">
        <a class="close-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="close" width="30px" height="30px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </a>
    </div>
    <div class="row text-center">
        <h4>CHI TIẾT ĐƠN HÀNG</h4>
    </div>
    <div class="row">
        <div class="col">
            Sản phẩm
        </div>
        <div class="col">
            Đơn giá
        </div>
        <div class="col">
            Số lượng
        </div>
        <div class="col">
            Thành tiền
        </div>
    </div>
    <hr>
    @foreach ($detailBill as $each)
        <div class="row">
            <div class="col">
                {{$each->name}}
            </div>
            <div class="col">
                {{$each->price}}
            </div>
            <div class="col">
                {{$each->quantity}}
            </div>
            <div class="col">
                ${{$each->price * $each->quantity}}
            </div>
        </div>
        <hr>
    @endforeach
</div>
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {

            if (localStorage.getItem('showDetailBillAlert') === 'true') {
                // Hiển thị div 'detail-bill-alert' nếu trạng thái là 'true'
                $('.detail-bill-alert').removeAttr('hidden');
                // Xóa trạng thái trong localStorage để tránh việc hiển thị ngoài ý muốn
                localStorage.removeItem('showDetailBillAlert');
            } else {
                $('.detail-bill-alert').attr('hidden', true);
            }

            $('td.status').each(function () {
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
            $('.search').change(function () {
                let searchKey = $(this).val();
                console.log(searchKey);
                let baseUrl = window.location.pathname;
                var fullUrl = baseUrl + '?q=' + encodeURIComponent(searchKey);
                window.location.href = fullUrl;
            })
            function getDetailBill(row) {
                const thisBill = row.find('.bill').text();
                console.log(thisBill);
                localStorage.setItem('showDetailBillAlert', 'true');
                let currentUrl = window.location.href;
                let params = new URLSearchParams(window.location.search);
                params.set('id', thisBill);
                let newUrl = window.location.pathname + '?' + params.toString();
                window.location.href = newUrl;
            }
            $('.detail-bill').on('click', async function () {
                const row = $(this).closest('tr');
                await getDetailBill(row);
            });
            $('.close-icon').on('click', function () {
                $('.detail-bill-alert').hide();
                $('.content').removeClass('blur');
            })
        });
    </script>
@endpush

@endsection