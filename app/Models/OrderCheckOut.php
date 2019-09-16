<?php

namespace App\Models;

class OrderCheckOut extends BaseModel
{
    public const CHECK_OUT_TYPE = 1;
    public const MOVE_OUT_TYPE = 2;

    public function material(){
        return $this->belongsTo('App\Models\Material','material_id');
    }
}
