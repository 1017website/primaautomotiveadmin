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
        'service_total', 'service_disc'
    ];

    public function service() {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

}
