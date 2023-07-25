<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class MixDetailTemp extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'mix_detail_temp';
    protected $fillable = [
        'user_id', 'product_id', 'weight'
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

    public function currentStock() {
        return $this->hasOne(InventoryRackPaint::class, 'product_id', 'product_id');
    }

}
