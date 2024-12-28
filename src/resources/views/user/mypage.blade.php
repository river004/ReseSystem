@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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
</div>
<div class="container">

<div class="user-text"><h1></h1><h2>{{ auth()->user()->name }}さん</h2></div>
    <div class="content-header">
        <div class="content-title"><h3>予約状況</h3></div>
        <div class="content-title"><h3>お気に入り店舗</h3></div>
    </div>
    <div class="mypage-flex">
        <div class="reservations-box">
                @forelse ($reservations as $index => $reservation)
                <div class="reservation-content">
                    <div class="reservation-unit">
                            <div class="reservation-item">予約{{ $index + 1 }}</div><br>
                            <div class="reservation-item">店名: <p>{{ $reservation->store->name }}</p></div><br>
                            <div class="reservation-item">予約日: <p>{{ $reservation->date }}</p></div><br>
                            <div class="reservation-item">予約時間: <p>{{ $reservation->time }}</p></div><br>
                            <div class="reservation-item">人数: <p>{{ $reservation->people }}人</p></div>
                        </li>
                    </div>
                    <div class="reservation-more">
                        @if ($reservation->status !== 'canceled')
                            <div class="cancel-box">
                                <form action="{{ route('reservation.cancel', $reservation->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <div class="circle-button">
                                    <button type="submit" class="cancel-button" onclick="return confirm('本当にキャンセルしますか？')">×</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <span class="text-muted">キャンセル済み</span>
                        @endif
                        <!-- QRコード -->
                        <div class="reservation-qr">
                            {!! QrCode::size(100)->generate(route('reservations.qr', ['id' => $reservation->id])) !!}
                        </div>
                        <div class="reservation-more-under">
                            <!-- 編集ボタン -->
                            <div class="edit-button">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editReservationModal"
                                    data-id="{{ $reservation->id }}"
                                    data-date="{{ $reservation->date }}"
                                    data-time="{{ $reservation->time }}"
                                    data-people="{{ $reservation->people }}">
                                    変更
                                </button>
                            </div>
                            <div class="review-button">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $reservation->id }}">
                                    評価する
                                </button>
                            </div>
                        </div>
                        <!-- モーダルウィンドウ -->
                        <div class="modal fade" id="reviewModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reviewModalLabel">評価とコメント</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('reviews.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="store_id" value="{{ $reservation->store->id }}">

                                            <div class="mb-3">
                                                <label for="rating" class="form-label">評価 (1〜5)</label>
                                                <select name="rating" id="rating" class="form-select" required>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="comment" class="form-label">コメント</label>
                                                <textarea name="comment" id="comment" class="form-control" rows="4"></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary">送信</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- モーダルウィンドウ -->
                        <div class="modal fade" id="editReservationModal" tabindex="-1" aria-labelledby="editReservationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="editReservationForm" method="POST" action="{{ route('reservations.update', $reservation->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editReservationModalLabel">予約を変更</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="reservation-id" name="id">

                                            <div class="mb-3">
                                                <label for="reservation-date" class="form-label">予約日</label>
                                                <input type="date" class="form-control" id="reservation-date" name="date" value="{{ old('date', $reservation->date) }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="reservation-time" class="form-label">予約時間</label>
                                                <input type="time" class="form-control" id="reservation-time" name="time" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="reservation-people" class="form-label">人数</label>
                                                <input type="number" class="form-control" id="reservation-people" name="people" min="1" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                            <button type="submit" class="btn btn-primary">保存する</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <li>予約はまだありません。</li>
                @endforelse
            
        </div>
        <div class="favorites-box">
            <div class="favorites-list">
                @forelse ($favorites as $store)
                    <div class="store-card">
                    <div class="card">
                        <img src="{{ asset('storage/' . $store->image) }}" class="card-img-top" alt="{{ $store->name }}">
                        <div class="card-body">
                            <h3>{{ $store->name }}</h3>
                            <p>{{ $store->area->name }} | {{ $store->genre->name }}</p>
                            <div class="card-under">
                                <a href="{{ route('store.show', $store->id) }}" class="store-detail"><p>詳細を見る</p></a>
                                @auth
                                    @if(auth()->user()->favoriteStores->contains($store->id))
                                    <!-- お気に入りに追加済みの場合、削除ボタン -->
                                    <form action="{{ route('favorites.remove', $store->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="favorite-button active">❤️ </button>
                                    </form>
                                    @else
                                        <!-- お気に入りに追加ボタン -->
                                        <form action="{{ route('favorites.add', $store->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="favorite-button">♡ </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <li>お気に入りの店舗はまだありません。</li>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection