<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NotifyUserMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class MailController extends Controller
{
    public function showSendMailForm()
    {
        return view('emails.send_mail');
    }

    public function sendMail(Request $request)
    {
        // バリデーション
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $subject = $request->input('subject');
        $messageContent = $request->input('message');

        // role が 'user' のユーザーを取得
        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            return back()->with('error', '対象のユーザーが見つかりませんでした。');
        }

        // 各ユーザーにメールを送信
        foreach ($users as $user) {
            Mail::to($user->email)->send(new NotifyUserMail($subject, $messageContent));
        }

        return back()->with('success', 'ユーザー全員にメールを送信しました！');
    }
}
