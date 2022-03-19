<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class StockInDetail extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'stock_in_detail';
    protected $fillable = [
        'inventory_stock_in_id', 'product_id', 'type_product_id', 'qty', 'price'
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
        return $this->hasOne(Typeproduct::class, 'id', 'type_product_id');
    }

    public function stockIn() {
        return $this->hasOne(StockIn::class, 'id', 'inventory_stock_in_id');
    }

}
