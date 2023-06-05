<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Customer extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'customer';
    protected $fillable = [
        'name', 'cars_id', 'car_types_id', 'car_brands_id', 'id_card', 'phone', 'address',
        'image', 'car_year', 'car_color', 'car_plate', 'status', 'image_url'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function detail() {
        return $this->hasMany(CustomerDetail::class, 'customer_id', 'id');
    }

    public function car() {
        return $this->hasOne(Car::class, 'id', 'cars_id');
    }

    public function carBrand() {
        return $this->hasOne(CarBrand::class, 'id', 'car_brands_id');
    }

    public function carType() {
        return $this->hasOne(CarType::class, 'id', 'car_types_id');
    }

}
