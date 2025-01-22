<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class MaterialUsage extends Model
{
    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'material_usage';
    protected $fillable = [
        'id_mechanic',
        'id_product',
        'description',
        'date',
        'qty',
        'id_type_product',
        'price',
        'total'
    ];

    public function userCreated()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function mechanic()
    {
        return $this->hasOne(Mechanic::class, 'id', 'id_mechanic');
    }

    public function product()
    {
        return $this->hasOne(StoreProduct::class, 'id', 'id_product');
    }

    public function typeProduct()
    {
        return $this->hasOne(StoreTypeProduct::class, 'id', 'id_type_product');
    }
}
