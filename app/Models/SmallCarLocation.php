<?php

namespace App\Models;

class SmallCarLocation extends BaseModel
{
    public function small_car_products(){
        return $this->hasMany(SmallCarProduct::class,'small_car_location_id');
    }

    public function small_car_materials(){
        return $this->hasMany(SmallCartMaterial::class,'small_car_location_id');
    }

    public function deleteRelation(){
        $this->small_car_products()->delete();
        $this->small_car_materials()->delete();
    }
}
