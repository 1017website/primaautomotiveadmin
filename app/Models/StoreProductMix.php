<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class StoreProductMix extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'store_products_mix';
    protected $fillable = [
        'name', 'price'
    ];

    public function typeProduct() {
        return $this->hasOne(StoreTypeProduct::class, 'id', 'type_product_id');
    }

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
