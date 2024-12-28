@extends('layouts.app')


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
    <div class="details">
        <h3>{{ $reservation->store->name }}</h3>
        <p><strong>店名:</strong> {{ $reservation->store->name }}</p>
        <p><strong>日付:</strong> {{ $reservation->date }}</p>
        <p><strong>時間:</strong> {{ $reservation->time }}</p>
        <p><strong>人数:</strong> {{ $reservation->people }} people</p>
    </div>
@endsection