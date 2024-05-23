<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblinstructorovertime extends Model
{
    use HasFactory;
    protected $table = 'tblinstructorovertime';
    protected $fillable = [
        'userid',
        'workdate',
        'datefiled',
        'status',
        'is_approved',
        'approver',
        'overtime_start',
        'overtime_end',
        'deletedid',
    ];

    public function personApprover(){
        return $this->belongsTo(User::class, 'approver', 'user_id');
    }

    public function userid(){
        return $this->belongsTo(User::class, 'userid','user_id');
    }

    public static function createData(array $data){
        return static::create($data);
    }
    
    public static function collectData(){
        return static::where('deletedid', 0);
    }

    public static function updateData(array $data){
        $data1 = static::find($data['id']);
        $check = $data1->update([
            'userid' => $data['userid'],
            'workdate' => $data['workdate'],
            'datefiled' => $data['datefiled'],
            'status' => $data['status'],
            'is_approved' => $data['is_approved'],
            'overtime_start' => $data['overtime_start'],
            'overtime_end' => $data['overtime_end'],
        ]);

        return $check;
    }
}
