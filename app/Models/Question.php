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
        return $this->belongsTo('App\Models\User');
    }

    public function tagCategory()
    {
        return $this->belongsTo('App\Models\TagCategory');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function getAllQuestion($id)
    {
        return $this->where('user_id', $id)->get();
    }

    public function getQuestionByMonth($requestWord)
    {
        return $this->where('title', 'like', '%'. $requestWord. '%')->get();
    }

    public function getQuestionByCategory($tagCategoryId)
    {
        return $this->where('tag_category_id', $tagCategoryId)->get();
    }
}
