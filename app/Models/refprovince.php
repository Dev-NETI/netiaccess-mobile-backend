<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class refprovince extends Model
{
    protected $table = 'refprovince';
    protected $primaryKey = 'id';

    use HasFactory;

    public function trainee()
    {
        return $this->hasMany(tbltraineeaccount::class, 'provCode', 'provCode');
    }
}
