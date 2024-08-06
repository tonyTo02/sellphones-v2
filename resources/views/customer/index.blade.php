@extends('layout.master')
@push('css')
    <style>
        .search-bar {
            width: 30%;
        }
    </style>
@endpush
@section('content')
<h1>Đây là trang quản lý Khách hàng</h1>
<div class="d-flex">
    <div class="p-1 me-auto">
        <a class="btn btn-primary" href="{{route('customer.create')}}">+ Create New Customer</a>
    </div>
    <div class="p-1 search-bar">
        <input name="q" type="text" class="search form-control" placeholder="Search">
    </div>
</div>
<table class="table max-w-7xl mx-auto p-6 lg:p-8 text-center">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Email</th>
        <th>Password</th>
        <th>Address</th>
        <th>Phone Number</th>
        <th>Create At</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    @foreach ($data as $each)
        <tr>
            <td>{{$each->id}}</td>
            <td>{{$each->name}}</td>
            <td>{{$each->getGender()}}</td>
            <td>{{$each->dob}}</td>
            <td>{{$each->email}}</td>
            <td>{{$each->password}}</td>
            <td>{{$each->address}}</td>
            <td>{{$each->phone_number}}</td>
            <td>{{$each->created_at}}</td>
            <td>
                <a href="{{route('customer.edit', $each->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{route('customer.destroy', $each->id)}}" method="post">
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
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
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
        });
    </script>
@endpush
@endsection