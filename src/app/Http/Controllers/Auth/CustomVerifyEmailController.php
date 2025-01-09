<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified; // メールが確認されたときに発火するイベント
use Illuminate\Routing\Controller; // 基本的なコントローラークラス
use Illuminate\Support\Facades\Redirect; // リダイレクト処理を行うためのファサード
use App\Models\User;

class CustomVerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash)
    {
        // ユーザーをIDで取得
        $user = User::findOrFail($id);

        // リンクのハッシュが正しいか確認
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'メール確認リンクが無効です。');
        }

        // すでに確認済みの場合
        if ($user->hasVerifiedEmail()) {
            return Redirect::route('thank-you'); // 感謝ページにリダイレクト
        }

        // 初めてメール確認を行う場合
        if ($user->markEmailAsVerified()) {
            event(new Verified($user)); // メール確認完了イベントを発火
        }

        // 登録感謝ページにリダイレクト
        return Redirect::route('thank-you');
    }
}
