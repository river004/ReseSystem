<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // 会員登録時の動作をカスタマイズ
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::registerView(function () {
        return view('auth.register');
        });

        // Registered イベントリスナーでリダイレクトをカスタマイズ
        \Event::listen(Registered::class, function ($event) {
            // 登録後に確認メール再送信ページにリダイレクト
            return redirect('/email/verify');
        });

        Fortify::loginView(function () {
        return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
        $email = (string) $request->email;

        return Limit::perMinute(10)->by($email . $request->ip());
        });

        Fortify::verifyEmailView(function () {
            return redirect()->route('thank-you');  // または指定したページにリダイレクト
        });
    }
}
