<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class tblenroled extends Model
{
    protected $table = 'tblenroled';
    protected $primaryKey = 'enroledid';
    protected $fillable = ['pendingid', 'deletedid', 'billingserialnumber', 'reservationstatusid', 'dormid', 'attendance_status','nabillnaid'];
    use HasFactory;

    public static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->enrolledby= Auth::guard('trainee')->check() ? Auth::guard('trainee')->user()->name_for_meal:Auth::user()->full_name;
        });
    }

    public function schedule()
    {
        return $this->belongsTo(tblcourseschedule::class, 'scheduleid');
    }

    public function course()
    {
        return $this->belongsTo(tblcourses::class, 'courseid');
    }

    public function trainee()
    {
        return $this->belongsTo(tbltraineeaccount::class, 'traineeid', 'traineeid');
    }

    public function fleet()
    {
        return $this->belongsTo(tblfleet::class, 'fleetid', 'fleetid');
    }

    public function payment()
    {
        return $this->belongsTo(tblpaymentmode::class, 'paymentmodeid');
    }

    public function dorm()
    {
        return $this->belongsTo(tbldorm::class, 'dormid');
    }

    public function attendance()
    {
        return $this->hasMany(tblscheduleattendance::class);
    }

    public function certificate()
    {
        return $this->belongsTo(tblcertificatehistory::class, 'traineeid', 'traineeid');
    }

    public function certificate_number()
    {
        return $this->belongsTo(tblcertificatehistory::class, 'traineeid', 'traineeid')
            ->where('enroledid', $this->enroledid)
            ->first();
    }

    public function cln()
    {
        return $this->belongsTo(tblclntype::class, 'cln_id');
    }

    public function dormitory()
    {
        return $this->belongsTo(tbldormitoryreservation::class, 'enroledid', 'enroledid');
    }

    public function reservationstatus()
    {
        return $this->belongsTo(tblreservationstatus::class, 'reservationstatusid', 'id');
    }

    public function bus()
    {
        return $this->belongsTo(tblbusmode::class, 'busmodeid');
    }

    public function tshirt()
    {
        return $this->belongsTo(tbltshirt::class, 'tshirtid');
    }

    public function old_schedule()
    {
        return $this->belongsTo(tblremedial::class, 'enroledid', 'enroledid');
    }

    public function tper_rating()
    {
        return $this->hasMany(Tper_evaluation_rating::class, 'enroled_id', 'enroledid');
    }

    public function mealmonitoring()
    {
        return $this->hasMany(tblmealmonitoring::class, 'enroledid', 'enroledid');
    }

    public function busmonitoring()
    {
        return $this->hasMany(tblbusmonitoring::class, 'enroledid', 'enroledid');
    }

    public function certificate_history()
    {
        return $this->belongsTo(tblcertificatehistory::class, 'enroledid', 'enroledid');
    }

    // ASSESSOR
    public function getDownloadDormRegFormAttribute()
    {
        return $this->dormid != 1 ?
            (
                Auth::user()->u_type === 1 ?
                '<a href="' . route('a.registration-form', ['enrollment_id' => $this->enroledid]) . '" class="h5" title="Download Registration Form">
                <span class="bi bi-download"></span>
            </a>'
                :
                '<a href="' . route('c.registration-form', ['enrollment_id' => $this->enroledid]) . '" class="h5" title="Download Registration Form">
                <span class="bi bi-download"></span>
            </a>'
            )
            :
            '';
    }

    public function getEnrollmentStatusAttribute()
    {
        if($this->pendingid === 0 && $this->deletedid === 0){
            $badge='<span class="badge bg-success">Enrolled</span>';
        }else if($this->pendingid === 0 && $this->deletedid === 1){
            $badge='<span class="badge bg-danger">Drop</span>';
        }else{
            $badge='<span class="badge bg-warning">Pending</span>';
        }
        return $badge;
    }
}
