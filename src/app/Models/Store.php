<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'image',
        'description',
        'area_id',
        'genre_id',
        'owner_id'
    ];

    // Storeが属するOwnerのリレーション
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Storeが属するAreaのリレーション
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Storeが属するGenreのリレーション
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * 店舗がお気に入りされているユーザー（多対多リレーション）
     */
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_stores');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // リレーション: 店舗に対する評価・コメント
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
