<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class InventoryProductHistory extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'inventory_product_history';
    protected $fillable = [
        'product_id', 'type_product_id', 'qty_in', 'qty_out', 'price', 'description'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function product() {
        return $this->hasOne(StoreProduct::class, 'id', 'product_id')->withTrashed();
    }

    public function typeProduct() {
        return $this->hasOne(StoreTypeProduct::class, 'id', 'type_product_id')->withTrashed();
    }

}
