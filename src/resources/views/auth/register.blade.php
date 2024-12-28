@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
<form method="post" action="/register" class="register-container">
    @csrf
    <div class="register-title">
    <p>Register</p>
    </div>
    <div class="input-container">
            <i class="fas fa-user"></i>
            <input class="input-field" id="username" type="text" name="name" placeholder="Username" autofocus>
    </div>

    <div class="input-container">
            <i class="fas fa-envelope"></i>
            <input class="input-field" id="email" type="email" name="email" placeholder="Email">
    </div>

    <div class="input-container">
            <i class="fas fa-lock"></i>
            <input class="input-field" id="password" type="password" name="password" placeholder="Password">
    </div>
    <div class="button-block">
        <button type="submit" class="register-button">登録</button>
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