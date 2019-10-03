<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'question_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getQuestionComments($id)
    {
        return $this->where('question_id', $id)->get();
    }
}
