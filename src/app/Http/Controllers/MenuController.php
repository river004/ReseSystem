<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // メニュー情報をここで取得することができます
        $role = auth()->user()->role??''; // 現在ログイン中のユーザーの権限を取得
        return view('menu.index', compact('role'));
    }

}
