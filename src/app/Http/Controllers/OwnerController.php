<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function index()
    {
        $stores = Store::where('owner_id', auth()->id())->get();

        // ログイン中のユーザー（店舗代表者）
        $user = Auth::user();

        // 店舗代表者が管理する店舗とその予約情報を取得
        $storeReservations = $user->stores()->with('reservations')->get();

        return view('owner.index', compact('stores','storeReservations'));
    }

    // 店舗作成画面
    public function create()
    {
        $areas = Area::all();
        $genres = Genre::all();
        return view('stores.create', compact('areas', 'genres'));
    }

    // 店舗保存処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'description' => 'nullable|string',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $data = $request->all();
        $data['owner_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('shops', 'public');
        }

        Store::create($data);

        return redirect()->route('shops.create')->with('success', '店舗を作成しました。');
    }

    // 店舗予約情報の表示
    public function reservations()
    {
        $shops = Store::where('owner_id', Auth::id())->with('reservations')->get();
        return view('shops.reservations', compact('shops'));
    }

    public function edit(Store $store)
    {
        // 認証されたオーナーの店舗かどうかを確認
        if ($store->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $areas = Area::all(); // エリアテーブルのデータを取得
        $genres = Genre::all(); // ジャンルテーブルのデータも必要なら取得

        return view('owner.edit', compact('store', 'areas', 'genres'));
    }

    // 店舗情報を更新
    public function update(Request $request, Store $store)
    {
        // 認証されたオーナーの店舗かどうかを確認
        if ($store->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        // 更新処理
        $store->update([
            'name' => $request->name,
            'description' => $request->description,
            'area_id' => $request->area_id,
            'genre_id'=> $request->genre_id,
        ]);


        return redirect()->route('owner.shops.index')->with('success', '店舗情報を更新しました！');
    }
}
