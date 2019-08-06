<?php

namespace App\Models;

class Material extends BaseModel
{
    public function Unit(){
        return $this->belongsTo('App\Models\Unit','unit_id','id');
    }
}
