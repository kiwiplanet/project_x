<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'staff_id',
        'email',
        'password',
    ];

    public function bookmarks(){
        return $this->hasMany(Bookmark::class);
    }

    //あるユーザーがブックマークしたアイテムのリソースを操作できるようにする
    public function bookmark_items()
    {
        return $this->belongsToMany(Item::class, 'bookmarks', 'user_id', 'item_id');
    }

    //登録または解除する前に、すでにブックマークしているかどうかをチェック
    public function is_bookmark($itemId)
    {
        return $this->bookmarks()->where('item_id', $itemId)->exists();
    }
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
