<?php

namespace App\Models;


class EmployeeBranch extends BaseModel
{
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }
}
