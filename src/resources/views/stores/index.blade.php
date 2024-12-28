@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
    <div class="search-box">
        <div class="search-bar">
            <!-- 検索フォーム -->
            <form method="GET" action="{{ route('stores.index') }}">
                    <select name="area" id="area">
                    <option value="">All area</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>

                <select name="genre" id="genre">
                    <option value="">All genre</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"><div class="search-icon"></div></button>

                <label for="name"></label>
                <input type="text" name="name" id="name" value="{{ request('name') }}" placeholder="Search...">
            </form>
        </div>
    </div>
</div>

<div class="container">
    @foreach ($stores as $store)
    <div class="store-card">
        <div class="card">
            <img src="{{ asset('storage/' . $store->image) }}" class="card-img-top" alt="{{ $store->name }}">
            <div class="card-body">
                <h3>{{ $store->name }}</h3>
                <p>#{{ $store->area->name }} #{{ $store->genre->name }}</p>
                <div class="card-under">
                    <a href="{{ route('store.show', $store->id) }}" class="store-detail"><p>詳細を見る</p></a>
                    @auth
                        @if(auth()->user()->favoriteStores->contains($store->id))
                        <!-- お気に入りに追加済みの場合、削除ボタン -->
                        <form action="{{ route('favorites.remove', $store->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="favorite-button active">❤️</button>
                        </form>
                        @else
                            <!-- お気に入りに追加ボタン -->
                            <form action="{{ route('favorites.add', $store->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="favorite-button">🤍</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

    {{ $stores->links() }}
@endsection