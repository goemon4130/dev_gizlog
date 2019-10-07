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

    public function scopeSearchTitle($query, $searchWord)
    {
        return $query->where('title', 'like', '%'. $searchWord. '%');
    }

    public function scopeSearchTagCategory($query, $selectTagCategoryId)
    {
        if ($selectTagCategoryId) {
            return $query->where('tag_category_id', $selectTagCategoryId);
        }
    }

    public function getUserAllQuestion($id)
    {
        return $this->where('user_id', $id)->latest()->get();
    }

    public function getQuestion($inputRequests, $id)
    {
        if(empty($inputRequests)) {
            return $this->getUserAllQuestion($id);
        } else {
            return $this->getFilteringQuestion($inputRequests, $id);
        }
    }

    public function getFilteringQuestion($inputRequests, $id)
    {
        return $this->activeUser($id)
                    ->searchTitle($inputRequests['search_word'])
                    ->searchTagCategory($inputRequests['select_tag_category_id'])
                    ->latest()
                    ->get();
    }
}
