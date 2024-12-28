@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/send_mail.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
    <h1>利用者にメールを送信</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('owner.sendMail') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="subject">件名:</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="message">メッセージ:</label>
            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">送信</button>
    </form>
</div>
@endsection