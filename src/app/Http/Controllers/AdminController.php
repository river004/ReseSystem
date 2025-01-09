<?php

namespace App\Http\Controllers\Role;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $owners = User::where('role', 'owner')->get();
        $role = auth()->user()->role; // 現在ログイン中のユーザーの権限を取得
        return view('admin.index', compact('owners', 'role'));
    }

    public function storeOwner(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'owner',
        ]);

        return redirect()->route('admin.index')->with('success', '店舗代表者が追加されました。');
    }
}
