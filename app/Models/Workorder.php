<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workorder extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $table = 'workorder';
    protected $fillable = [
        'code', 'order_id', 'invoice_id', 'mechanic_id', 'date', 'date_done', 
        'description', 'document', 'status', 'document_url'
    ];

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function invoice() {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }

    public function mechanic() {
        return $this->hasOne(Mechanic::class, 'id', 'mechanic_id');
    }

    public function detail() {
        return $this->hasMany(WorkorderDetail::class, 'workorder_id', 'id');
    }

    public function getStatus() {
        if ($this->status == '0') {
            return 'Deleted';
        } elseif ($this->status == '1') {
            return 'Progress';
        } elseif ($this->status == '2') {
            return 'Done';
        }
    }

}
