<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ServiceParent extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'name', 'panel', 'type_service_id'
    ];

    public function service() {
        return $this->hasMany(Service::class, 'parent_id', 'id');
    }

    public function typeService() {
        return $this->hasOne(TypeService::class, 'id', 'type_service_id');
    }
	
    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
