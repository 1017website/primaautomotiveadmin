<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class WashSaleDetail extends Model
{
    use HasFactory,
        Userstamps;

    protected $table = 'wash_sales_detail';
    protected $fillable = [
        'order_id',
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

    public function order()
    {
        return $this->hasOne(WashSale::class, 'id', 'order_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
}
