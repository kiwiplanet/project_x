<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    // 多対多の関係を定義
    public function seasonItems()
    {
        return $this->belongsToMany(SeasonItem::class);
    }
}
