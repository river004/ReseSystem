<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Models\User;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // 登録フォームのビューを返す
        return view('auth.register');
    }

    /**
     * 既定のリダイレクト先を指定
     *
     * @var string
     */
    protected $redirectTo = '/email/verify'; // 登録後のリダイレクト先

    /**
     * ユーザーを登録した後にリダイレクトする。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // 登録後のリダイレクト処理
        event(new Registered($user));

        return redirect($this->redirectTo);  // 設定したリダイレクト先
    }
}
