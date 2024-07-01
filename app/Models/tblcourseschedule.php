<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class tblcourseschedule extends Model
{
    protected $table = 'tblcourseschedule';
    protected $primaryKey = 'scheduleid';
    use HasFactory;

    protected $fillable = [
        'batchno',
        'courseid',
        'coursecode',
        'startdateformat',
        'enddateformat',
        'dateonsitefrom',
        'dateonsiteto',
        'dateonlinefrom',
        'dateonlineto',
    ];

    public function course()
    {
        return $this->belongsTo(tblcourses::class, 'courseid', 'courseid');
    }

    public function instructor()
    {
        return $this->belongsTo(tblinstructor::class, 'instructorid', 'userid');
    }

    public function altinstructor()
    {
        return $this->belongsTo(tblinstructor::class, 'alt_instructorid', 'userid');
    }

    public function assessor()
    {
        return $this->belongsTo(tblinstructor::class, 'assessorid', 'userid');
    }

    public function altassessor()
    {
        return $this->belongsTo(tblinstructor::class, 'alt_assessorid', 'userid');
    }

    public function room()
    {
        return $this->belongsTo(tblroom::class, 'roomid');
    }

    public function count_enrolled()
    {
        return $this->hasMany((tblenroled::class));
    }

    public function ins_license()
    {
        return $this->belongsTo(tblinstructorlicense::class, 'instructorlicense', 'instructorlicense');
    }

    public function asses_license()
    {
        return $this->belongsTo(tblinstructorlicense::class, 'assessorlicense', 'instructorlicense');
    }

    public function enroll()
    {
        return $this->hasMany(tblenroled::class, 'scheduleid', 'scheduleid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'instructorid', 'user_id');
    }

    // ENCAPSULATION
    public function getTrainingDateAttribute()
    {
        $startDate = Carbon::parse($this->startdateformat);
        $endDate = Carbon::parse($this->enddateformat);
        return $startDate->format('M. d, Y') . " to " . $endDate->format('M. d, Y');
    }

    public function billing_attachment()
    {
        return $this->hasMany(billingattachment::class, 'scheduleid', 'scheduleid');
    }

    public function getScheduleWithTrainingDateAttribute()
    {
        return $this->course->coursecode . " " . $this->course->coursename . " " . $this->getTrainingDateAttribute();
    }

    public function getDropdownNameAttribute()
    {
        return $this->batchno;
    }

    public function getDropdownIdAttribute()
    {
        return $this->batchno;
    }
}
