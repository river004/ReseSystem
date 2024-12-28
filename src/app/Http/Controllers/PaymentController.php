<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    /**
     * 決済フォームを表示
     */
    public function showPaymentForm()
    {
        return view('payment.form');
    }

    /**
     * 決済を処理
     */
    public function processPayment(Request $request)
    {
        // Stripe秘密鍵を設定
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // チェックアウトセッションを作成
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Reservation Payment',
                    ],
                    'unit_amount' => 5000, // 金額 (USDの場合、5000 = $50.00)
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.form'),
        ]);

        // セッションIDをフロントに渡す
        return redirect($session->url, 303);
    }


    /**
     * 決済成功後のリダイレクト
     */
    public function success()
    {
        return view('payment.success');
    }

    public function handleReturn(Request $request)
    {
        // 必要に応じて追加の処理を行います
        return redirect()->route('reservation.complete')->with('success', 'Payment completed successfully!');
    }
}
