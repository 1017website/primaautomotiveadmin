<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class PengaturanWorkday extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'workday_year', 'workday_periode', 'workday_week', 'workday_kunjungan', 'workday_pekan', 'workday_day',
        'workday_status', 'workday_user', 'created_at', 'updated_at', 'workday_seasonal'
    ];

}
