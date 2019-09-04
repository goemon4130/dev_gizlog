<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use softDeletes;

    protected $fillable = ['title', 'content', 'reporting_time', 'user_id'];

    protected $dates = ['reporting_time'];

    public function getMonthlyDailyReport($inputMonth, $userId)
    {
        return $this->where('user_id', $userId)
                    ->where('reporting_time', 'like', $inputMonth. '%')
                    ->orderby('reporting_time', 'desc')
                    ->get();
    }

    public function getAllDailyReport($userId)
    {
        return $this->where('user_id', $userId)->latest('reporting_time')->get();
    }
}
