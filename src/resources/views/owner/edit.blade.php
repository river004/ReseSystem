@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/store_edit.css') }}">
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
    <div class="store-edit">
        <h1>編集</h1>

        <form action="{{ route('owner.shops.update', $store->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">店舗名</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $store->name) }}" required>
            </div>

            <div class="form-group">
                <label for="area_id">エリア</label>
                <select name="area_id" id="area_id" class="form-control">
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ $store->area_id == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="genre_id">ジャンル</label>
                <select name="genre_id" id="genre_id" class="form-control">
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ $store->genre_id == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">店舗概要</label>
                <textarea id="description" name="description" class="form-control" required>{{ old('description', $store->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
</div>
@endsection