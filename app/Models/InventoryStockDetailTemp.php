<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class InventoryStockDetailTemp extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'inventory_stock_detail_temp';
    protected $fillable = [
        'user_id', 'product_id', 'type_product_id', 'qty', 'price', 'type'
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

    public function typeProduct() {
        return $this->hasOne(TypeProduct::class, 'id', 'type_product_id');
    }

}
