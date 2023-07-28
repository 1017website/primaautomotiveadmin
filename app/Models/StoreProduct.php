<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class StoreProduct extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'store_products';
    protected $fillable = [
        'name', 'type_product_id', 'image', 'barcode', 'hpp', 'margin_profit', 
        'price', 'document', 'um', 'image_url', 'document_url', 'berat_timbang', 'berat_jenis', 'berat_kemasan'
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
