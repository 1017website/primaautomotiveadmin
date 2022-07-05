<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreChasier extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'store_chasier';
    protected $fillable = [
        'code', 'date', 'total', 'dp', 'status', 'status_payment', 'date_dp', 'date_done', 'cust_id', 'description'
    ];

    public function customer() {
        return $this->hasOne(StoreCustomer::class, 'id', 'cust_id');
    }
	
    public function detail() {
        return $this->hasMany(StoreChasierDetail::class, 'header_id', 'id');
    }
	
    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function workorder() {
        return $this->hasOne(Workorder::class, 'id', 'workorder_id');
    }

    public function getStatus() {
        if ($this->status == '0') {
            return 'Deleted';
        } elseif ($this->status == '1') {
            return 'Active';
        }
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
