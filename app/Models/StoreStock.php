<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class StoreStock extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'store_stock';
    protected $fillable = [
        'date', 'description'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function detail() {
        return $this->hasMany(StoreStockDetail::class, 'store_stock_id', 'id');
    }

}
