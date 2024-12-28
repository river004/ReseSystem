<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request, $storeId) {

    $validated = $request->validate([
        'payment_method_id' => 'required|string',
    ]);
        // Stripe API キーを設定
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Stripe で支払いを作成
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => 5000, // 金額 (5000 = $50.00)
                'currency' => 'usd',
                'payment_method' => $validated['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.return'), // リダイレクト先のURL
            ]);

            $validated = $request->validated();
            // 支払いが成功したら予約を保存
            $reservation = new Reservation();
            $reservation->user_id = auth()->id();
            $reservation->store_id = $validated['store_id']; // フォームから受け取るか設定
            $reservation->date = $validated['date'];
            $reservation->time = $validated['time'];
            $reservation->people = $validated['people'];
            $reservation->status = 'pending';
            $reservation->save();

            return redirect()->route('reservation.success', ['reservation' => $reservation->id]);
        }catch (\Exception $e) {
            return back()->withErrors(['error' => 'Payment failed: ' . $e->getMessage()]);
        }
    }

    public function success($reservationId)
    {
        // 予約を確認済みに更新
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->update(['status' => 'confirmed']);

        return view('reservations.complete', ['reservation' => $reservation]);
    }

    public function cancel(Reservation $reservation)
    {
        // ユーザーがこの予約を所有しているか確認
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // キャンセル処理
        $reservation->update(['status' => 'canceled']);

        return back()->with('message', '予約をキャンセルしました。');
    }

    // 予約編集フォームを表示
    public function edit(Reservation $reservation)
    {
        // 認証されたユーザーの予約かどうか確認
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('reservations.edit', compact('reservation'));
    }

    // 予約情報を更新
    public function update(Request $request, $id)
    {
        // リクエストをバリデート
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'people' => 'required|integer|min:1',
        ]);

        // 予約を取得
        $reservation = Reservation::findOrFail($id);

        // 予約情報を更新
        $reservation->date = $validated['date'];
        $reservation->time = $validated['time'];
        $reservation->people = $validated['people'];
        $reservation->save();

        return redirect()->route('mypage')->with('success', '予約情報を更新しました！');
    }
    /**
     * QRコードを表示する
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showQr($id)
    {
        // 予約情報を取得
        $reservation = Reservation::findOrFail($id);

        // ビューにデータを渡す
        return view('reservations.qr', compact('reservation'));
    }
}
