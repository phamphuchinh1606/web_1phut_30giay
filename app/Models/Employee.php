<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\BaseModel;

class Employee extends Authenticatable
{
    use Notifiable;

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getPrimaryKeyName()
    {
        return with(new static)->getKeyName();
    }

    public static function getFillableColumns()
    {
        return with(new static)->getFillable();
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    public function employee_branches(){
        return $this->hasMany(EmployeeBranch::class,'employee_id');
    }

    public function employee_roles(){
        return $this->hasMany(EmployeeRole::class,'employee_id');
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
