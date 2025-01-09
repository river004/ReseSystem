@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
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
    
    <form action="{{ route('shops.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h2>店舗作成</h2>
        <div>
            <label for="name">店名</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="image">店舗画像</label>
            <input type="file" name="image" id="image">
        </div>
        <div>
            <label for="description">店舗概要</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div>
            <label for="area_id">エリア</label>
            <select name="area_id" id="area_id">
                @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="genre_id">ジャンル</label>
            <select name="genre_id" id="genre_id">
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">作成</button>
    </form>
</div>
@endsection