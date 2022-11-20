<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class CarImage extends Model {

    use HasFactory,
        Userstamps;

    protected $fillable = [
        'car_id', 'image', 'size', 'image_url'
    ];

    public function car() {
        return $this->hasOne(Car::class, 'id', 'car_id');
    }

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
