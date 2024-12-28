<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request) {
        $query = Store::query();

        // エリア、ジャンル、店名での検索機能
        if ($request->has('area') && !empty($request->input('area'))) {
            $query->where('area_id', $request->input('area'));
        }

        if ($request->has('genre') && !empty($request->input('genre'))) {
            $query->where('genre_id', $request->input('genre'));
        }

        if ($request->has('name') && !empty($request->input('name'))) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $stores = $query->paginate();

        $areas = Area::all();
        $genres = Genre::all();

        return view('stores.index', compact('stores', 'areas', 'genres'));
    }

    public function show($id) {
        $store = Store::with('reviews.user')->findOrFail($id);

        // 平均評価を計算
        $averageRating = $store->reviews->avg('rating');

        return view('stores.show', [
        'store' => $store,
        'averageRating' => number_format($averageRating, 1), // 小数点1桁にフォーマット
    ]);
    }

    public function create()
    {
        $areas = Area::all();
        $genres = Genre::all();
        return view('shops.create', compact('areas', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 画像を保存
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // 店舗を保存
        Shop::create([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('shops.index')->with('success', '店舗が追加されました！');
    }
}
