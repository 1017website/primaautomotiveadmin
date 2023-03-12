<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDetailTemp extends Model {

    protected $table = 'customer_detail_temp';
    protected $fillable = [
        'customer_id', 'cars_id',
        'car_year', 'car_color', 'car_plate', 'user_id'
	];

    public function head() {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
	
    public function car() {
        return $this->hasOne(Car::class, 'id', 'cars_id');
    }

}
