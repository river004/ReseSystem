@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/Verify-email.css') }}">
@endsection


@section('content')
<div class="container">
    <div class="Verify-email-box">
        <h1>Verify Your Email Address</h1>
        <p>確認メールがあなたのメールアドレスに送信されました。確認してください。</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">確認メールを再送信</button>
        </form>
    </div>
</div>
@endsection