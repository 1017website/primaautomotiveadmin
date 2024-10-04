<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class WashSaleDetailTemp extends Model
{
    use HasFactory,
        Userstamps;

    protected $table = 'wash_sales_detail_temp';
    protected $fillable = [
        'user_id',
        'service_id',
        'service_name',
        'service_price',
        'service_qty',
        'service_total',
        'service_disc'
    ];

    public function userCreated()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
}
