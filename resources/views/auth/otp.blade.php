@extends('layout.guess')
@section('content')
@push('css')
    <style>

    </style>
@endpush
<div class="container centered-form d-flex justify-content-center align-items-center py-5">
    <div class="card shadow-lg p-4" style="width: 25rem;">
        @if (session()->get('middlewareMessage'))
            <h5 class="text-center text-danger">{{session()->get('middlewareMessage')}}</h5>
        @endif

        <form action="{{route('auth.register.new')}}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" id="email" name="email"
                    value="{{session()->get('customerEmail')}}">
            </div>
            <div class="form-group">
                <label for="password">Mã OTP:</label>
                <input type="text" class="form-control" id="text" name="otp_code" required>
            </div>
            @error('otp_code')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <button type="submit" class="mt-3 mb-3 btn btn-primary btn-block form-control">Verify</button>
        </form>

    </div>
</div>
@endsection