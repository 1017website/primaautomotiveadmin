<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class AttendancePermitType extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'name'
    ];

    public function employee() {
        return $this->hasOne(Mechanic::class, 'id', 'employee_id');
    }

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
