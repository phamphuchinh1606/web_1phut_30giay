<?php

namespace App\Repositories\Eloquents;

use App\Common\Constant;
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

    public function getEmployeeByBranch($branchId){
        return $this->model->where('delete_flg',Constant::DELETE_FLG_OFF)->where('branch_id',$branchId)->get();
    }

    public function getEmployeeSaleSmall($branchId){
        return $this->model->where('delete_flg',Constant::DELETE_FLG_OFF)
            ->where('branch_id',$branchId)
            ->where('employee_sale_card_small',Constant::EMPLOYEE_SALE_CARD_SMALL)
            ->get();
    }

    public function getEmployeeDaily($branchId, $date){
        $employeeDailyTable = EmployeeDaily::getTableName();
        $employeeTable = $this->model::getTableName();
        return $this->model->where("$employeeTable.delete_flg",Constant::DELETE_FLG_OFF)
            ->where("$employeeTable.branch_id",$branchId)
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
