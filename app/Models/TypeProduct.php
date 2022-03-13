<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class TypeProduct extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'name',
    ];

    public function userCreated() {
        return $this->hasOne(user::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(user::class, 'id', 'updated_by');
    }

}
