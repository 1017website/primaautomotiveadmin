<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Mix extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'mix';
    protected $fillable = [
        'date', 'description','code', 'name', 'type_product_id', 'qty', 'um', 'hpp', 'margin_profit', 'price', 'berat_timbang', 'berat_jenis', 'berat_kemasan'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
	
    public function detail() {
        return $this->hasMany(MixDetail::class, 'mix_id', 'id');
    }
}
