<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ExpenseInvestment extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'expense_investment';
    protected $fillable = [
        'description', 'date', 'cost', 'shrink'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
