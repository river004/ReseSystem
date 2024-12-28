@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
<div class="navbar">
    <div class="navbar-box">
        <div class="navbar-icon">
            <a class="menu-icon" href="{{ route('menu.index') }}"><i class="fas fa-bars"></i></a>
        </div>
        <div class="navbar-title" >
            <a class="title-text" href="{{ route('stores.index') }}">Rese</a>
        </div>
    </div>
</div>
<div class="container">
<form method="post" action="/login" class="login-container">
    @csrf
        <div class="login-title">
            <p>Login</p>
        </div>
        <div class="input-container">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" class="input-field" value="{{ old('email') }}" placeholder="Email">
        </div>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" class="input-field" placeholder="Password">
        </div>
        <div class="button-block">
            <button type="submit" class="login-button">ログイン</button>
        </div>
</form>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>
@endsection