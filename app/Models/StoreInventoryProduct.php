<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class StoreInventoryProduct extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'store_inventory_product';
    protected $fillable = [
        'product_id', 'type_product_id', 'price', 'qty', 'status'
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

}
