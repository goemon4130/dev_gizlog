<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use softDeletes;

    protected $fillable = ['title', 'content', 'reporting_time', 'user_id'];

    protected $dates = ['reporting_time'];

    public function dateSearch($inputMonth)
    {
        return $this->where('user_id', Auth::id())
                    ->where('reporting_time', 'like', $inputMonth. '%')
                    ->get();
    }

    public function getAll()
    {
        return $this->where('user_id', Auth::id())->get();
    }
}
