<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class EstimatorTemp extends Model {

    use HasFactory,
        Userstamps;

    protected $table = 'estimator_temp';
    protected $fillable = [
        'session_id', 'service_id', 'service_name', 'service_price', 'service_qty',
        'service_total', 'service_disc', 'type_color_id', 'color_id',
        'type_service_id', 'car_id'
    ];

    public function service() {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function typeColor() {
        return $this->hasOne(Color::class, 'id', 'type_color_id');
    }

    public function color() {
        return $this->hasOne(PrimerColor::class, 'id', 'color_id');
    }

    public function typeService() {
        return $this->hasOne(TypeService::class, 'id', 'type_service_id');
    }

    public function car() {
        return $this->hasOne(Car::class, 'id', 'car_id');
    }

}
