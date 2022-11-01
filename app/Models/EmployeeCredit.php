<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class EmployeeCredit extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'employee_id', 'date', 'description', 'total', 'tenor', 'status'
    ];

    public function employee() {
        return $this->hasOne(Mechanic::class, 'id', 'employee_id');
    }

    public function detail() {
        return $this->hasMany(EmployeeCreditDetail::class, 'employee_credit_id', 'id');
    }

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
