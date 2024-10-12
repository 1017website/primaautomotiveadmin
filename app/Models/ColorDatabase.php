<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ColorDatabase extends Model
{
    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'color_database';

    protected $fillable = [
        'id_color_code',
        'id_color_group',
        'id_color_category',
        'id_car_brands',
        'name',
        'code_price',
    ];

    public function userCreated()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function brand()
    {
        return $this->hasOne(CarBrand::class, 'id', 'id_car_brands');
    }

    public function code()
    {
        return $this->hasOne(Color::class, 'id', 'id_color_code');
    }

    public function group()
    {
        return $this->hasOne(ColorGroup::class, 'id', 'id_color_group');
    }

    public function category()
    {
        return $this->hasOne(ColorCategory::class, 'id', 'id_color_category');
    }
}
