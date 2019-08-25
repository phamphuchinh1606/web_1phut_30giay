<?php

namespace App\Models;
use CompositeKeyModelHelper;


class RolePermissionScreen extends BaseModel
{

    public function screen(){
        return $this->belongsTo(Screen::class,'screen_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class,'permission_id');
    }

}
