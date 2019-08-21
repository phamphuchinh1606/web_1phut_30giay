<?php

namespace App\Models;

class Employee extends BaseModel
{
    public function employee_branches(){
        return $this->hasMany(EmployeeBranch::class,'employee_id');
    }

    public function deleteRelation(){
        $this->employee_branches()->delete();
    }

    public function checkAssetBranch($branchId){
        foreach ($this->employee_branches as $employeeBranch){
            if($branchId == $employeeBranch->branch_id){
                return true;
            }
        }
        return false;
    }
}
