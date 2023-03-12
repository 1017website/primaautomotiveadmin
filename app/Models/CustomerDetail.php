<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class CustomerDetail extends Model {

    protected $table = 'customer_detail';
    protected $fillable = [
        'customer_id', 'cars_id',
        'car_year', 'car_color', 'car_plate'
	];

    public function head() {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
	
    public function car() {
        return $this->hasOne(Car::class, 'id', 'cars_id');
    }

}
