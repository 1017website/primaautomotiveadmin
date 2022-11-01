<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class EmployeeCreditDetail extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'employee_credit_id', 'employee_id', 'date', 'total', 'description', 'status'
    ];

    public function credit() {
        return $this->hasOne(EmployeeCredit::class, 'id', 'employee_credit_id');
    }

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
