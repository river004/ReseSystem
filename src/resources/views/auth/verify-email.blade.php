@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/Verify-email.css') }}">
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
    <div class="Verify-email-box">
        <div class="Verify-email-text">
            <h1>Verify Your Email Address</h1>

            <p>確認メールがあなたのメールアドレスに送信されました。</br>確認してください。</p>
        </div>
    </div>
</div>
@endsection