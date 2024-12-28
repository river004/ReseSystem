@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://js.stripe.com/v3/"></script>
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
    <div class="store-flex">
        <div class="detail">
            <div class="detail-nav">
                <div class="navbar-close">
                    <!-- 戻るボタン -->
                    <button onclick="window.history.back()" class="close-button"><p><</p></button>
                </div>
                <div class="store-title">
                    <h2> {{ $store->name }}</h2>
                </div>
            </div>

            <div class="store-details">
                <div class="store-img">
                    <img src="{{ asset('storage/' . $store->image) }}" class="card-img-top" alt="{{ $store->name }}">
                </div>
                <div class="store-categories">
                    <p>#{{ $store->area->name }} #{{ $store->genre->name }}</p>
                </div>
                <p>{{ $store->description }}</p>
                <!-- 評価の平均を表示 -->
                <div class="evaluation">
                    <h3>評価: {{ $averageRating }} </h3>
                </div>

                <!-- コメント一覧 -->
                <h4>レビューとコメント</h4>
                @if ($store->reviews->count() > 0)
                    @foreach ($store->reviews as $review)
                        <div class="card mb-3">
                            <div class="card-body">
                                <p><strong>評価:</strong> {{ $review->rating }} / 5</p>
                                <p><strong>コメント:</strong> {{ $review->comment }}</p>
                                <p><small>投稿者: {{ $review->user->name ?? 'ゲスト' }}</small></p>
                            </div>
                        </div>
                    @endforeach
                @else
                <p>まだレビューがありません。</p>
                @endif
            </div>
        </div>
        <div class="reservation">
            <div class="reservation-form">
            <h3 class="reservation-title">予約</h3>
            <form action="{{ route('reservations.store', $store->id) }}" method="POST">
            @csrf
            <!-- 店舗情報 -->
            <div class="form-input">
                <label for="store_id"
                ></label>
                <input type="hidden" name="store_id" id="store_id" value="{{ $store->id}}" oninput="updateDisplay()">
                @error('store_id')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-input">
                <label for="date">予約日</label>
                <input type="date" name="date" id="date" class="form-control" oninput="updateDisplay()">
            @error('date')
            <p class="text-danger">{{ $message }}</p>
            @enderror
            </div>

            <div class="form-input">
                <label for="time">予約時間</label>
                <input type="time" name="time" id="time" class="form-control" oninput="updateDisplay()">
            @error('time')
            <p class="text-danger">{{ $message }}</p>
            @enderror
            </div>

            <div class="form-input">
                <label for="people">人数</label>
                <input type="number" name="people" id="people" class="form-control" oninput="updateDisplay()">
            @error('people')
            <p class="text-danger">{{ $message }}</p>
            @enderror
            </div>

            <!-- 決済情報 -->
            <div class="form-input">
                <h2>お支払い情報</h2>
                <label for="card-element">クレジットカードまたはデビットカード:</label>
                <div id="card-element" class="Payment-input">
                    <!-- Stripe Elements のカード入力フォーム -->
                </div>
                <div id="card-errors" role="alert"></div>
            </div>
            <br>
            <div class="output">
            <p>店名: {{ $store->name }}</p>
            <p>予約日: <span id="displayDate"></span></p>
            <p>予約時間: <span id="displayTime"></span></p>
            <p>人数: <span id="displayPeople"></span></p>
            </div>

            @if (auth()->check())
                    <button type="submit" class="btn btn-primary">予約する</button>
            @else
                <p>予約を行うには<a href="{{ route('login') }}">ログイン</a>してください。</p>
            @endif
            </form>
            @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
            @endif

            <script>
                const stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}');
                const elements = stripe.elements();
                const card = elements.create('card', {
                    hidePostalCode: true // 郵便番号を非表示にする
                });;
                card.mount('#card-element');

                const form = document.querySelector('form');
                const submitButton = document.getElementById('submit-button');

                form.addEventListener('submit', async (event) => {
                    event.preventDefault();

                    const { paymentMethod, error } = await stripe.createPaymentMethod({
                        type: 'card',
                        card: card,
                    });

                    if (error) {
                        // エラー表示
                        document.getElementById('card-errors').textContent = error.message;
                    } else {
                        // Stripe PaymentMethod ID をフォームに追加して送信
                        const hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'payment_method_id');
                        hiddenInput.setAttribute('value', paymentMethod.id);
                        form.appendChild(hiddenInput);

                        form.submit();
                    }
                });
            </script>
            

            <script>
                function updateDisplay() {
                const date = document.getElementById('date').value;
                const time = document.getElementById('time').value;
                const people = document.getElementById('people').value;
                document.getElementById('displayDate').textContent = date;
                document.getElementById('displayTime').textContent = time;
                document.getElementById('displayPeople').textContent = people;
                }
            </script>

            </div>
        </div>
    </div>
</div>
@endsection