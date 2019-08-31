<?php

namespace App\Repositories\Eloquents;

use App\Common\Constant;
use App\Models\AssignEmployeeSaleCartSmall;
use App\Models\EmployeeBranch;
use App\Models\EmployeeDaily;
use App\Repositories\Base\BaseRepository;
use App\Models\Employee;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class EmployeeRepository extends BaseRepository
{
    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function delete($id){
        $itemModel = $this->model->find($id);
        if(isset($itemModel)){
            $itemModel->deleteRelation();
            $itemModel->delete_flg = 1;
            $itemModel->save();
        }
    }

    public function getEmployeeAll(){
        $tableEmployeeName = Employee::getTableName();
        return $this->model->where('delete_flg',Constant::DELETE_FLG_OFF)->get();
    }

    public function getEmployeeByBranch($branchId){
        $tableEmployeeName = Employee::getTableName();
        $tableEmployeeBranchName = EmployeeBranch::getTableName();
        return $this->model->where('delete_flg',Constant::DELETE_FLG_OFF)
            ->join($tableEmployeeBranchName,"$tableEmployeeBranchName.employee_id","$tableEmployeeName.id")
            ->where("$tableEmployeeBranchName.branch_id",$branchId)->get();
    }

    public function getEmployeeSaleSmall($branchId, $employeeId = null){
        $tableEmployeeName = Employee::getTableName();
        $tableEmployeeBranchName = EmployeeBranch::getTableName();
        $tableAssignEmployeeSaleCartSmallName = AssignEmployeeSaleCartSmall::getTableName();
        $query = $this->model->where('delete_flg',Constant::DELETE_FLG_OFF)
            ->join($tableEmployeeBranchName,"$tableEmployeeBranchName.employee_id","$tableEmployeeName.id")
            ->join($tableAssignEmployeeSaleCartSmallName,"$tableAssignEmployeeSaleCartSmallName.employee_id","$tableEmployeeName.id")
            ->where("$tableEmployeeBranchName.branch_id",$branchId)
            ->where('employee_sale_card_small',Constant::EMPLOYEE_SALE_CARD_SMALL);
        if(isset($employeeId)){
            $query->where("$tableEmployeeName.id", $employeeId);
        }
        $query->select("$tableEmployeeName.*");
        return $query->get();
    }

    public function getEmployeeDaily($branchId, $date){
        $employeeDailyTable = EmployeeDaily::getTableName();
        $employeeTable = $this->model::getTableName();
        $tableEmployeeBranchName = EmployeeBranch::getTableName();
        return $this->model->where("$employeeTable.delete_flg",Constant::DELETE_FLG_OFF)
            ->where("$tableEmployeeBranchName.branch_id",$branchId)
            ->join($tableEmployeeBranchName,"$tableEmployeeBranchName.employee_id","$employeeTable.id")
            ->leftjoin($employeeDailyTable,function($join) use ($branchId,$date, $employeeTable,$employeeDailyTable){
                $join->on("$employeeTable.id","$employeeDailyTable.employee_id")
                    ->where("$employeeDailyTable.branch_id",$branchId)
                    ->where("$employeeDailyTable.date_daily",$date->format('Y-m-d'));
            })
            ->select(["$employeeTable.id","$employeeTable.name","$employeeDailyTable.first_hours",
                "$employeeDailyTable.last_hours","$employeeDailyTable.price_first_hour", "$employeeDailyTable.price_last_hour"])
            ->selectRaw("(ifnull($employeeDailyTable.first_hours,0) * ifnull($employeeDailyTable.price_first_hour,0)) + (ifnull($employeeDailyTable.last_hours,0)*ifnull($employeeDailyTable.price_last_hour,0)) as total_amount_employee")
            ->get();
    }
}
