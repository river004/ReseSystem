<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Validator;
use App\Models\Reservation;

class UserController extends Controller
{
    public function mypage() {
        $user = auth()->user();
        $reservations = $user->reservations()->with('store')->where('status', '!=', 'canceled') // キャンセル済みを除外
            ->orderBy('date', 'asc')->get();
        $favorites = $user->favoriteStores()->get();

        return view('user.mypage', compact('reservations', 'favorites'));
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

}
