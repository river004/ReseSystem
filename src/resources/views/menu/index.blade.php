@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endsection

@section('content')
<div class="navbar">
    <div class="navbar-box">
        <div class="navbar-close">
            <!-- 戻るボタン -->
            <button onclick="window.history.back()" class="close-button">×</button>
        </div>
    </div>
</div>

<div class="container">
    <div class="menu-box">
        <div class="menu-link" style="margin-top: 20px;">
            <a href="{{ route('stores.index') }}">Home</a>
        </div>
        <!-- 他のページへのリンク -->
        @auth
        <div class="menu-link" style="margin-top: 20px;">
            <a href="{{ route('mypage') }}">Mypage</a>
        </div>
        <!-- 管理者権限を持っているとき -->
        @if ($role === 'admin')
        <div class="menu-link" style="margin-top: 20px;">
            <a href="{{ route('admin.index') }}">Admin</a>
        </div>
        @endif
        <!-- 店舗代表者権限を持っているとき -->
        @if ($role === 'owner')
        <div class="menu-link" style="margin-top: 20px;">
            <a href="{{ route('owner.shops.index') }}">Owner</a>
        </div>
        @endif
        <!-- ログイン中の場合はログアウトボタン -->
        <form action="{{ route('logout') }}" method="POST" class="menu-link" style="margin-top: 20px;">
            @csrf
            <button type="submit">Logout</button>
        </form>

        @else
        <!-- 非ログイン中の場合はログインボタンと会員登録ボタン -->
        <div class="menu-link" style="margin-top: 20px;">
            <a href="{{ route('login') }}">Login</a>
        </div>
        <div class="menu-link" style="margin-top: 20px;">
            <a href="{{ route('register') }}">Registration</a>
        </div>
        @endauth
    </div>
</div>

@endsection