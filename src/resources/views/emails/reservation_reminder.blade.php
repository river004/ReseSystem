<!DOCTYPE html>
<html>
<head>
    <title>リマインダー: 予約日のお知らせ</title>
</head>
<body>
    <h1>リマインダー: 予約日のお知らせ</h1>
    <p>{{ $reservation->user->name }}様</p>

    <p>以下の予約日が本日です。</p>
    <ul>
        <li><strong>店舗名:</strong> {{ $reservation->store->name }}</li>
        <li><strong>予約日:</strong> {{ $reservation->date }}</li>
        <li><strong>時間:</strong> {{ $reservation->time }}</li>
        <li><strong>人数:</strong> {{ $reservation->people }}名</li>
    </ul>

    <p>ご来店をお待ちしております！</p>

    <p>※このメールは自動送信されています。</p>
</body>
</html>