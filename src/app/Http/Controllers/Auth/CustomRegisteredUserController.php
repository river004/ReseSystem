<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomRegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        // 入力データのバリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
        ]);

        // ユーザー作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 登録イベントを発火
        event(new Registered($user));

        // ユーザーをログイン状態にしない（ここでログインさせない）
        // Auth::login($user);

        // 確認メール再送信ページにリダイレクト
        return redirect()->route('verification.notice');
    }
}
