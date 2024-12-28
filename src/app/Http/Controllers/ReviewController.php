<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'store_id' => 'required|exists:stores,id',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'store_id' => $request->store_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', '評価を追加しました。');
    }
}
