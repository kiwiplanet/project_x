<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'bookmarks';
    
    protected $fillable = [
        'user_id', 
        'item_id'
    ];

    // ユーザーに対する関連付け
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // アイテムに対する関連付け
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
