@extends('layout.master')
@push('css')
    <style>
        .search-bar {
            width: 30%;
        }

        td {
            align-content: center;
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
<h4>
    <a class="btn btn-primary" href="https://dashboard.stripe.com/test/payments">
        Click Here To Go Detail Page
    </a>
</h4>
<table class="table max-w-7xl mx-auto p-6 lg:p-8 text-center">
    <tr>
        <th>Mã giao dịch</th>
        <th>Mã đơn hàng</th>
        <th>Số tiền</th>
        <th>Thời gian thực hiện giao dịch</th>
        <th>Trạng thái</th>
        <th>Hoàn trả</th>
        <th>Biên lai</th>
    </tr>
    @foreach ($data as $transaction)
        <tr>
            <td>{{$transaction->id}}</td>
            <td>{{$transaction->metadata['bill_id']}}</td>
            <td>{{($transaction->amount / 100) . " " . $transaction->currency}}</td>
            <td>{{date('m-d-Y', $transaction->created)}}</td>
            <td>{{$transaction->status}}</td>
            <td>{{$transaction->refunded ? 'true' : 'false'}}</td>
            <td>
                <a href="{{$transaction->receipt_url}}" class="btn btn-success">Chi tiết</a>
            </td>
        </tr>
    @endforeach
</table>
<div class="mt-8">
</div>

@push('js')

@endpush

@endsection