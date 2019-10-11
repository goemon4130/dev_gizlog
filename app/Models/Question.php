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

    public function scopeActiveUser($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeSearchTitle($query, $inputRequests)
    {
        if (isset($inputRequests['search_word'])) {
            return $query->where('title', 'like', '%'. $inputRequests['search_word']. '%');
        }
    }

    public function scopeSearchTagCategory($query, $inputRequests)
    {
        if (isset($inputRequests['select_tag_category_id']) and $inputRequests['select_tag_category_id'] !== '0') {
            return $query->where('tag_category_id', $inputRequests['select_tag_category_id']);
        }
    }

    public function getQuestion($inputRequests, $id)
    {
        return $this->activeUser($id)->searchTitle($inputRequests)->searchTagCategory($inputRequests)->with(['user', 'tagCategory', 'comments'])->latest()->get();
    }

    public function getMyPostedQuestion($id)
    {
        return $this->activeUser($id)->with(['tagCategory', 'comments'])->latest()->get();
    }
}
