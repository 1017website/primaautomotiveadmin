<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Mechanic extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'mechanic';
    protected $fillable = [
        'name', 'id_card', 'birth_date', 'phone', 'address', 'image', 'status', 'position', 'salary',
        'positional_allowance', 'healthy_allowance', 'other_allowance', 'image_url'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
