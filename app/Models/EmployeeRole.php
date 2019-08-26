<?php

namespace App\Models;


class EmployeeRole extends BaseModel
{
    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
}
