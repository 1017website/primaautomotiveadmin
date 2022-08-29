<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class StoreStockDetail extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'store_stock_detail';
    protected $fillable = [
        'store_stock_id', 'product_id', 'type_product_id', 'qty', 'price', 'type'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function product() {
        return $this->hasOne(StoreProduct::class, 'id', 'product_id');
    }

    public function typeProduct() {
        return $this->hasOne(StoreTypeProduct::class, 'id', 'type_product_id');
    }

    public function stock() {
        return $this->hasOne(StoreStock::class, 'id', 'inventory_stock_id');
    }

    public function currentStock() {
        return $this->hasOne(StoreInventoryProduct::class, 'product_id', 'product_id', 'price', 'price');
    }

}
