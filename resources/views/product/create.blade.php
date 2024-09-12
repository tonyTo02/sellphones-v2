@extends('layout.master')
@section('content')
<h1>This Is Create Form</h1>
<form action="{{route('product.store')}}" method="post" enctype="multipart/form-data" class="form">
    @csrf
    <div class="group-input">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" value="{{old('name')}}">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="description" class="form-label">Mô tả sản phẩm</label>
        <textarea name="description" class="form-control" value="{{old('description')}}"></textarea>
        @error('description')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="image" class="form-label">Ảnh sản phẩm đại diện</label>
        <input type="file" name="image" class="form-control" value="{{old('image')}}">
        @error('image')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="more_images" class="form-label">Ảnh sản phẩm bổ sung</label>
        <input type="file" name="more_images[]" class="form-control" value="{{old('more_images[]')}}" multiple>
    </div>
    <div class="group-input">
        <label for="price" class="form-label">Giá sản phẩm</label>
        <input type="text" name="price" class="form-control" value="{{old('price')}}">
        @error('price')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <label for="manufacturer_id" class="form-label">Nhà sản xuất</label>
        <select name="manufacturer_id">
            @foreach ($each as $item)
                <option value="{{$item['id']}}">{{$item['name']}}</option>
            @endforeach
        </select>
        @error('manufacturer_id')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    <div class="group-input">
        <br>
        <button class="btn btn-success">Create</button>
    </div>
</form>
@endsection