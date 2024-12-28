@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thank-you.css') }}">
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
    <div class="thank-you-box">
        <h3>会員登録ありがとうございます</h3>
        <a href="{{ route('login') }}">ログインする</a>
    </div>
</div>
@endsection