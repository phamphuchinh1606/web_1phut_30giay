<?php

namespace App\Models;

class Role extends BaseModel
{
    public function role_type(){
        return $this->belongsTo(RoleType::class, 'role_type_id');
    }

    public function role_permission_screens(){
        return $this->hasMany(RolePermissionScreen::class,'role_id');
    }
}
