@extends('layout.master')
@section('content')
<form action="{{route('admin.slideshow.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    Thêm Ảnh
    <input type="file" name="images[]" class="form-control" multiple>
    <button class="btn btn-primary">Submit</button>
</form>

<div class="row">
    @foreach ($images as $image)
        <div class="col text-center">
            <img src="{{asset('storage') . '/' . $image->image_path}}" alt="ảnh slide show" width="690px" height="300px">
            <div class="row">
                <div class="col text-center">
                    <form action="{{route('admin.slideshow.destroy', $image->id)}}" method="post">
                        @csrf
                        @METHOD('DELETE')
                        <button class="btn btn-danger">Xóa Ảnh</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection