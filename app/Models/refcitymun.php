<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class refcitymun extends Model
{
    protected $table = 'refcitymun';
    protected $primaryKey = 'id';

    use HasFactory;

    // public function trainee()
    // {
    //     return $this->hasMany(refcitymun::class, 'citynumCode', 'citynumCode');
    // }
}
