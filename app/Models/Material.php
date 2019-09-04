<?php

namespace App\Models;

class Material extends BaseModel
{
    public function Unit(){
        return $this->belongsTo('App\Models\Unit','unit_id','id');
    }

    public function material_type(){
        return $this->belongsTo('App\Models\MaterialType','material_type_id','id');
    }

    public function Supplier(){
        return $this->belongsTo('App\Models\Supplier','supplier_id','id');
    }
}
