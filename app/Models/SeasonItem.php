<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonItem extends Model
{
    protected $table = 'season_items';

    protected $fillable = [
        'season_id',
        'item_id',
    ];

    // アイテムに対する関連付け
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // シーズンに対する関連付け
    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
