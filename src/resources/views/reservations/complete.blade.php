@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/complete.css') }}">
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
    <div class="complete-box">
        <div class="title-info">
            <h1>{{ $reservation->store->name }}の予約が完了しました。</h1>
        </div>
        <div class="home-link">
            <a href="/">HOME</a>
        </div>
    </div>
</div>
@endsection