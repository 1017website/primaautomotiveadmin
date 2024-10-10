<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class WashExpensesProduct extends Model
{
    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'wash_expenses_products';
    protected $fillable = [
        'code',
        'name',
        'date',
        'price',
        'stock'
    ];

    public function userCreated()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
