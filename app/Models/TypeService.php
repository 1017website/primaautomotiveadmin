<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class TypeService extends Model {

    use HasFactory,
        SoftDeletes,
        Userstamps;

    protected $fillable = [
        'name', 'color_id'
    ];

    public function colorDetail() {
        $listColor = "";
        if (strlen($this->color_id) > 0) {
            $colors = explode(",", $this->color_id);
            if (!empty($colors)) {
                foreach ($colors as $colorId) {
                    $modelColor = Color::where('id', $colorId)->first();
                    if (!empty($modelColor)) {
                        $listColor .= $modelColor->name . ', ';
                    }
                }
                $listColor = substr($listColor, 0, -2);
            }
        }

        return $listColor;
    }

    public function userCreated() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function userUpdated() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

}
