<?php

namespace App\Models;

class MaterialType extends BaseModel
{
    public function materials(){
        return $this->hasMany('App\Models\Material','material_type_id');
    }
}
