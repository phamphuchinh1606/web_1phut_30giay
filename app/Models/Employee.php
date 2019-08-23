<?php

namespace App\Models;

class Employee extends BaseModel
{
    public function employee_branches(){
        return $this->hasMany(EmployeeBranch::class,'employee_id');
    }

    public function assign_sale_cart_smalls(){
        return $this->hasMany(AssignEmployeeSaleCartSmall::class,'employee_id');
    }

    public function deleteRelation(){
        $this->employee_branches()->delete();
        $this->assign_sale_cart_smalls()->delete();
    }

    public function checkAssetBranch($branchId){
        foreach ($this->employee_branches as $employeeBranch){
            if($branchId == $employeeBranch->branch_id){
                return true;
            }
        }
        return false;
    }

    public function checkAssignSaleCartSmall($branchId){
        foreach ($this->assign_sale_cart_smalls as $assignEmployeeSaleCartSmall){
            if($branchId == $assignEmployeeSaleCartSmall->branch_id){
                return true;
            }
        }
        return false;
    }
}
