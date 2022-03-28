<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'order';
    protected $fillable = [
        'code', 'date', 'description', 'cust_name', 'cust_id_card', 'cust_address', 'cust_phone',
        'vehicle_type', 'vehicle_brand', 'vehicle_name', 'vehicle_year', 'vehicle_color',
        'vehicle_plate', 'vehicle_document', 'status'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function detail() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function getStatus() {
        if ($this->status == '0') {
            return 'Deleted';
        } elseif ($this->status == '1') {
            return 'Active';
        } elseif ($this->status == '2') {
            return 'Invoice';
        } elseif ($this->status == '3') {
            return 'Work Order';
        } elseif ($this->status == '4') {
            return 'Done';
        }
    }

}