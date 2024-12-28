<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // 一括代入を許可する属性
    protected $fillable = [
        'shop_id',
        'user_id',
        'date',
        'time',
        'people',
        'status',
    ];

    // 予約が属しているユーザーを定義 (多対1リレーション)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
