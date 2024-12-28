@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner.css') }}">
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
    <div class="email">
        <a href="{{ route('owner.sendMailForm') }}">mail</a>
    </div>
</div>
<div class="container">
    <div class="flex-box">
        <div class="store-box">
            <div class="store-header">
                <h1>店舗管理</h1>
                <div class="store-create">
                    <a href="{{ route('shops.create') }}" class="store-create-link">新しい店舗を作成</a>
                </div>
            </div>
            @foreach ($stores as $store)
            <div class="store-list">
                <div class="store-name">{{ $store->name }}</div>
                <div class="store-edit"><a href="{{ route('owner.shops.edit', $store->id) }}" class="store-edit-link">編集</a></div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="flex-box">
        <div class="reservations-box">
        <h2>店舗の予約情報</h2>
            <div class="reservations-list">
                @forelse ($stores as $store)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>{{ $store->name }}</h4>
                        </div>
                        <div class="card-body">
                            @if ($store->reservations->isEmpty())
                                <p>予約情報がありません。</p>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>予約日</th>
                                            <th>予約時間</th>
                                            <th>人数</th>
                                            <th>予約者名</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($store->reservations as $index => $reservation)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $reservation->date }}</td>
                                                <td>{{ $reservation->time }}</td>
                                                <td>{{ $reservation->people }}</td>
                                                <td>{{ $reservation->user->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                @empty
                    <p>管理している店舗がありません。</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection