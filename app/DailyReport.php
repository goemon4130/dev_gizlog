<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = ['title', 'content', 'reporting_time', 'user_id', 'deleted_at'];

    protected $dates = ['reporting_time'];

    public function getAll($date)
    {
        return $this->where('reporting_time', $date)->get();
    }
}
