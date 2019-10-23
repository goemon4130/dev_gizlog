<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'tag_category_id', 'title', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tagCategory()
    {
        return $this->belongsTo(TagCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeActiveUser($query, $request)
    {
        if (isset($request['user_id'])) {
            return $query->where('user_id', $request['user_id']);
        }
    }

    public function scopeSearchTitle($query, $request)
    {
        if (isset($request['search_word'])) {
            return $query->where('title', 'like', '%'. $request['search_word']. '%');
        }
    }

    public function scopeSearchTagCategory($query, $request)
    {
        if (isset($request['select_tag_category_id'])) {
            return $query->where('tag_category_id', $request['select_tag_category_id']);
        }
    }

    public function getQuestion($request)
    {
        return $this->activeUser($request)->searchTitle($request)->searchTagCategory($request)->with(['user', 'tagCategory', 'comments'])->latest()->get();
    }
}
