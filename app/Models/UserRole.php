<?php

namespace App\Models;


class UserRole extends BaseModel
{
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
}
