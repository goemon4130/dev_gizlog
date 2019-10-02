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
        return $this->where('user_id', $id)->latest()->get();
    }

    public function getQuestionByInputWord($requestWord)
    {
        return $this->where('title', 'like', '%'. $requestWord. '%')->latest()->get();
    }

    public function getQuestionByCategory($tagCategoryId)
    {
        return $this->where('tag_category_id', $tagCategoryId)->latest()->get();
    }

    public function getMyPostedQuestions($id)
    {
        return $this->where('user_id', $id)->latest()->get();
    }

    public function getFilteringQuestion($inputRequests)
    {
        if($inputRequests['select_tag_category_id'] === '0' or is_null($inputRequests['select_tag_category_id'])) {
            $questions = $this->where('title', 'like', '%'. $inputRequests['search_word']. '%')
                              ->latest()
                              ->get();
        } else {
            $questions = $this->where('title', 'like', '%'. $inputRequests['search_word']. '%')
                              ->where('tag_category_id', $inputRequests['select_tag_category_id'])
                              ->latest()
                              ->get();
        }
        return $questions;
    }
}
