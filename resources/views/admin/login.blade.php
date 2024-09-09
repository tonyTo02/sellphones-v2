@extends('layout.master')
@push('css')

@endpush
@section('content')
@if (session()->get('checkAdmin'))
    <div class="container text-center text-danger">
        <div class="row">
            <div class="col">
                <h2>
                    THÔNG BÁO!
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h4>
                    {{session()->get('checkAdmin')}}
                </h4>
            </div>
        </div>
    </div>
@endif
<div class="container centered-form d-flex justify-content-center align-items-center py-5">
    <div class="card shadow-lg p-4" style="width: 25rem;">
        <h2 class="text-center">Login</h2>
        <form action="{{route('admin.login')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="mt-3 btn btn-primary btn-block form-control">Login</button>
            @if (session()->get('message'))
                <span class="text-danger">{{session()->get('message')}}</span>
            @endif
        </form>
        <hr>
        <div class="text-center">
            <a href="#">
                <img src="https://cdn.icon-icons.com/icons2/2119/PNG/512/google_icon_131222.png" alt="Logo Gooogle"
                    style="width:30px; height:30px">
            </a>
        </div>
    </div>
</div>
@endsection