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

    public function scopeSearchTitle($query, $inputs)
    {
        if (isset($inputs['search_word'])) {
            return $query->where('title', 'like', '%'. $inputs['search_word']. '%');
        }
    }

    public function scopeSearchTagCategory($query, $inputs)
    {
        if (isset($inputs['select_tag_category_id']) and $inputs['select_tag_category_id'] !== '0') {
            return $query->where('tag_category_id', $inputs['select_tag_category_id']);
        }
    }

    public function getQuestion($id, $inputs = null)
    {
        return $this->activeUser($id)->searchTitle($inputs)->searchTagCategory($inputs)->with(['user', 'tagCategory', 'comments'])->latest()->get();
    }
}
