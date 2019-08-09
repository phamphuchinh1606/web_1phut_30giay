<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\EmployeeDaily;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class EmployeeDailyRepository extends BaseRepository
{
    public function __construct(EmployeeDaily $model)
    {
        $this->model = $model;
    }

    public function sumTotalDaily($branchId, $date){
        if(!is_string($date)){
            $date = $date->format('Y-m-d');
        }
        return $this->model::where('branch_id',$branchId)
            ->where('date_daily',$date)
            ->selectRaw("sum(first_hours) as first_hours_total, sum(last_hours) as last_hours_total, 
                sum(first_hours*price_first_hour) as amount_first_total, sum(last_hours*price_last_hour) as amount_last_total")
            ->first();
    }

    public function sumTotalAmountEmployeeDaily($branchId, $date, $employeeId){
        return $this->model::where('branch_id',$branchId)
            ->where('date_daily',$date)
            ->where('employee_id',$employeeId)
            ->selectRaw("(ifnull(first_hours,0) * ifnull(price_first_hour,0)) + (ifnull(last_hours,0)*ifnull(price_last_hour,0)) as total_amount_employee")
            ->first();
    }

    public function getEmployeeByMonth($branchId,$date){
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('date_daily',">=",$firstDate)
            ->where('date_daily',"<=",$lastDate)
            ->orderBy('date_daily')->orderBy('employee_id')
            ->get();
    }

    public function getEmployeeTotalByMonth($branchId,$date){
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('date_daily',">=",$firstDate)
            ->where('date_daily',"<=",$lastDate)
            ->groupBy('employee_id')
            ->selectRaw("employee_id,sum(first_hours) as total_first_hour, sum(last_hours) as total_last_hour, sum(first_hours * price_first_hour) as total_first_amount, sum(last_hours * price_last_hour) as total_last_amount")
            ->get();
    }

}
