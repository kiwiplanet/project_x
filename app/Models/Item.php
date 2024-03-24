<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'img_path',
        'buyer',
        'unit_price',
        'regular_stock',
        'total_stock',
        'kitchen_stock',
        'second_stock',
        'smach_stock',
        'detail'
    ];

    // アイテムに対する関連付け
    public function seasonItems()
    {
        return $this->belongsToMany(SeasonItem::class);
    }
    // Seasonモデルに対してSeasonItemを介してアクセスする
    public function seasons()
    {
        return $this->hasManyThrough(Season::class, SeasonItem::class,'item_id', 'id', 'id', 'season_id');
    }


    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
}
