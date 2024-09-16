<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class WashProduct extends Model
{
    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'wash_products';

    protected $fillable = [
        'name',
        'selling_price',
        'buying_price',
        'stock'
    ];

    public function userCreated()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
