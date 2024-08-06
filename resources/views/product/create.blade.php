@extends('layout.master')
@section('content')
<h1>This Is Create Form</h1>
<form action="{{route('product.store')}}" method="post" class="form">
    @csrf
    <div class="group-input">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="group-input">
        <label for="description" class="form-label">Mô tả sản phẩm</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="group-input">
        <label for="image" class="form-label">Ảnh sản phẩm</label>
        <input type="file" name="image" class="form-control">
    </div>
    <div class="group-input">
        <label for="price" class="form-label">Giá sản phẩm</label>
        <input type="text" name="price" class="form-control">
    </div>
    <div class="group-input">
        <label for="manufacturer_id" class="form-label">Nhà sản xuất</label>
        <select name="manufacturer_id">
            @foreach ($each as $item)
                <option value="{{$item['id']}}">{{$item['name']}}</option>
            @endforeach
        </select>
    </div>
    <div class="group-input">
        <br>
        <button class="btn btn-success">Create</button>
    </div>
</form>
@endsection