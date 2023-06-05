<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class StoreCustomer extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'store_customer';
    protected $fillable = [
        'name', 'phone', 'address', 'image', 'image_url'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
