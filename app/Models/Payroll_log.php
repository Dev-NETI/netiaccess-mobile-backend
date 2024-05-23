<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll_log extends Model
{
    use HasFactory;
    protected $tables = 'payroll_logs';
    protected $fillable = [
        'user_id',
        'category_id',
        'course_id',
        'no_day',
        'no_hr',
        'no_ot',
        'rate_per_day',
        'rate_per_hr',
        'subtotal',
        'date_covered_start',
        'date_covered_end',
        'period_start',
        'period_end',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(tblcourses::class, 'course_id', 'courseid');
    }
}
