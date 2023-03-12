<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class OrderProduct extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'order_product';
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'product_price', 'product_qty',
        'total', 'disc'
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

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
