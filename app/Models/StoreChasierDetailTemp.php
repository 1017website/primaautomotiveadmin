<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class StoreChasierDetailTemp extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'store_chasier_detail_temp';
    protected $fillable = [
        'user_id', 'stock_id', 'type_product_id', 'product_id', 'product_name', 'product_price', 'qty'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
