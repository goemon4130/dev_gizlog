<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class DailyReport extends Model
{
    protected $fillable = ['title', 'content', 'reporting_time', 'user_id', 'deleted_at'];

    protected $dates = ['reporting_time'];

    public function dateSearch($input)
    {
        return $this->where('user_id', Auth::id())
                    ->where('reporting_time', 'like', $input. '%')
                    ->get();
    }

    public function getAll()
    {
        return $this->where('user_id', Auth::id())->get();
    }
}
