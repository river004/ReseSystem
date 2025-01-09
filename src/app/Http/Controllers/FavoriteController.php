<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function add(Store $store)
    {
        $user = auth()->user();

        // 既にお気に入りに登録されていない場合のみ追加
        if (!$user->favoriteStores->contains($store->id)) {
            $user->favoriteStores()->attach($store->id);
        }

        return redirect()->back()->with('success', 'お気に入りに追加しました');
    }

    public function remove(Store $store)
    {
        $user = auth()->user();

        // お気に入りに登録されている場合のみ削除
        if ($user->favoriteStores->contains($store->id)) {
            $user->favoriteStores()->detach($store->id);
        }

        return redirect()->back()->with('success', 'お気に入りから削除しました');
    }
}
