<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Color extends Model
{

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'name',
        'id_color_group',
    ];

    public function userCreated()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function colorGroup()
    {
        return $this->belongsTo(ColorGroup::class, 'id_color_group');
    }

}
