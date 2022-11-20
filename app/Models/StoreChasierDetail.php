<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class StoreChasierDetail extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'store_chasier_detail';
    protected $fillable = [
        'workorder_id', 'stock_id', 'type_product_id' ,'product_id', 
        'product_name', 'product_price', 'qty', 'disc'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function workorder() {
        return $this->hasOne(Workorder::class, 'id', 'workorder_id');
    }

    public function product() {
        return $this->hasOne(StoreProduct::class, 'id', 'product_id');
    }

}
