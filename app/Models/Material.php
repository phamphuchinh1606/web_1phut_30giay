<?php

namespace App\Models;

class Material extends BaseModel
{
    public const MATERIAL_CHICKEN_ID = 11;
    public const MATERIAL_MEAT_ID = 12;
    public const MATERIAL_EGG_ID = 13;
    public const MATERIAL_SAUSAGE_ID = 16;
    public const MATERIAL_PEPSI_ID = 18;
    public const MATERIAL_COCOA_ID = 24;
    public const MATERIAL_MILK_TEA = 26;


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

