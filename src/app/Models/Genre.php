<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Genreが複数のShopを持つリレーション
    public function stores()
    {
        return $this->hasMany(Shop::class);
    }
}
