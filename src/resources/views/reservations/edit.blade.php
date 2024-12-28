@extends('layouts.app')

@section('content')
<div class="navbar">
    <div class="navbar-icon">
        <a class="menu-icon" href="{{ route('menu.index') }}"><i class="fas fa-bars"></i></a>
    </div>
    <div class="navbar-title" >
        <a class="title-text" href="{{ route('stores.index') }}">Rese</a>
    </div>
</div>
<div class="container">
    <h1>予約情報を編集</h1>

    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="date">日付</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $reservation->date) }}" required>
        </div>

        <div class="form-group">
            <label for="time">時間</label>
            <input type="time" id="time" name="time" class="form-control" value="{{ old('time', $reservation->time) }}" required>
        </div>

        <div class="form-group">
            <label for="number">人数</label>
            <input type="number" id="people" name="people" class="form-control" value="{{ old('people', $reservation->people) }}" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection