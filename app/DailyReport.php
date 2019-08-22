<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = ['title', 'content', 'reporting_time', 'user_id', 'deleted_at'];
}
