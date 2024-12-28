@extends('layouts.app')

@section('content')
<h1>Verify Your Email Address</h1>
    <p>A verification link has been sent to your email address. Please check your inbox.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Resend Verification Email</button>
    </form>
@endsection