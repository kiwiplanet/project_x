<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    // シーズンに対する関連付け
    public function seasonItems()
    {
        return $this->belongsToMany(SeasonItem::class);
    }
}
