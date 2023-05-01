<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use App\Models\Service;

class CarProfileTmp extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

	protected $table = 'car_profile_tmp';
    protected $fillable = [
        'car_id', 'service_id'
    ];

    public function service() {
         return $this->hasOne(Service::class, 'id', 'service_id');
    }

}
