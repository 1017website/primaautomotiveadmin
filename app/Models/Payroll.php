<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Payroll extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'employee_id', 'month', 'start_date', 'end_date', 'attendance', 'employee_salary',
        'positional_allowance', 'healty_allowance', 'other_allowance', 'bonus', 'year',
        'description_other', 'total_other', 'penalty', 'credit', 'total_salary', 'status'
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
	
    public function getStatusPayment() {
        if ($this->status_payment == '0') {
            return 'Unpaid';
        } elseif ($this->status_payment == '1') {
            return 'Dp';
        } elseif ($this->status_payment == '2') {
            return 'Paid';
        }
    }

    public function getColorPayment() {
        if ($this->status_payment == '0') {
            return 'btn-danger';
        } elseif ($this->status_payment == '1') {
            return 'btn-warning';
        } elseif ($this->status_payment == '2') {
            return 'btn-success';
        }
    }
}
