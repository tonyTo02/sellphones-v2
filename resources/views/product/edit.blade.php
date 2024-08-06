@extends('layout.master')
@section('content')
<h1>This Is Edit Form</h1>
<form action="{{route('product.update', $each->id)}}" method="post" class="form">
    @csrf
    @method('PUT')
    <div class="group-input">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" value="{{$each->name}}">
    </div>
    <div class="group-input">
        <label for="description" class="form-label">Mô tả sản phẩm</label>
        <textarea name="description" class="form-control">{{$each->description}}</textarea>
    </div>
    <div class="group-input">
        <label for="image" class="form-label">Ảnh sản phẩm</label>
        <input type="text" name="image" class="form-control" value="{{$each->image}}">
        <input type="file" name="new_image" class="form-control">
    </div>
    <div class="group-input">
        <label for="price" class="form-label">Giá sản phẩm</label>
        <input type="text" name="price" class="form-control" value="{{$each->price}}">
    </div>
    <div class="group-input">
        <label for="manufacturer" class="form-label">Nhà sản xuất</label>
        <select name="manufacturer_id" class="form-control">
            @foreach ($selectOption as $item)
                <option value="{{$item['id']}}" {{$item['id'] === $each->manufacturer_id ? "selected" : ''}}>{{$item['name']}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="group-input">
        <br>
        <button class="btn btn-success">Save</button>
    </div>
</form>
@endsection