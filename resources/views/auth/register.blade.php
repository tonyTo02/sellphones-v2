@extends('layout.guess')
@section('content')
@push('css')
    <style>
    </style>
@endpush
<div class="container centered-form d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="width: 25rem;">
        <h2 class="text-center">Đăng ký</h2>
        <form action="{{route('auth.register.process')}}" method="POST">
            @csrf
            <input type="text" name="dob" value="2000/01/01" hidden>
            <input type="text" name="avatar" value="avatar" hidden>
            <input type="text" name="gender" value="0" hidden>
            <input type="text" class="form-control" name="address" value="Default Address" hidden>
            <input type="text" class="form-control" name="phone_number" value="0123456789" hidden>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" required value="{{old('email')}}">
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{old('name')}}">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required
                    value="{{old('password')}}">
                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="re-password">Re Enter Password:</label>
                <input type="password" class="form-control" id="re-password" name="re-password"
                    value="{{old('re-password')}}" required>
            </div>
            <button type="submit" class="mt-3 btn btn-primary btn-block form-control">Sign Up</button>
        </form>
        <hr>
        @foreach ($errors->all() as $error)
            <li>{{$error}} </li>
        @endforeach

    </div>
</div>
@push('js')

@endpush('js')
@endsection