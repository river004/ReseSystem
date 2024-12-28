@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
@if ($role === 'admin')
<div class="container">
    <div class="owner-box">
        <div class="box-round">
            <div class="owner-list">
                <h2>店舗代表者一覧</h2>
                @foreach ($owners as $owner)
                    <div class="owner-users">
                        <div class="owner-name">{{ $owner->name }}</div>
                        <div class="owner-email">({{ $owner->email }})</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="owner-box">
        <div class="box-round">
            <div class="owner-create">
                <h2>店舗代表者の追加</h2>
                <form action="{{ route('admin.owners.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">名前</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="register-button">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
    <p>アクセス権限がありません。</p>
@endif
@endsection