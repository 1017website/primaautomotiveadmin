<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $fillable = [
        'name',
        'url',
        'parent',
        'level',
        'order'
    ];

    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'id_menu', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'id_menu', 'id_user');
    }
}
