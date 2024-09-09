@extends('layout.master')
@section('content')
<form action="{{route('admin.store')}}" method="post">
    @csrf
    Name
    <input type="text" name="name">
    <br>
    Email
    <input type="text" name="email">
    <br>
    Password
    <input type="text" name="password">
    <br>
    <button>Submit</button>
</form>
@endsection