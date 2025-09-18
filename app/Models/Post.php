<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'content',
        'user_id',
        'img_url',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withTimestamps();
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withTimestamps();
    }

    public function isLikedBy($user)
    {
        // 多対多のリレーションを使って、指定されたユーザーがこの投稿にいいねしているかを確認
        return $user ? $this->likes()->where('user_id', $user->id)->exists() : false;
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'post_tag');
    }
    // この投稿をブックマークしているユーザーとの関係
    public function bookmarkedByUsers()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    // 指定されたユーザーがこの投稿をブックマークしているか判定する
    public function isBookmarkedBy($user)
    {
        // ログインしていないユーザーの場合は常にfalse
        if (!$user) {
            return false;
        }
        return $this->bookmarkedByUsers()->where('user_id', $user->id)->exists();
    }
}
