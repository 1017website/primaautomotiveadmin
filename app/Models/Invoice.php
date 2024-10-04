<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'invoice';
    protected $fillable = [
        'code', 'date', 'order_id', 'total', 'dp', 'status', 'status_payment', 'date_dp', 'date_done'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function washOrder() {
        return $this->hasOne(WashSale::class, 'id', 'order_id');
    }

    public function getStatus() {
        if ($this->status == '0') {
            return 'Deleted';
        } elseif ($this->status == '1') {
            return 'Active';
        } elseif ($this->status == '2') {
            return 'Work Order';
        } elseif ($this->status == '3') {
            return 'Done';
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
