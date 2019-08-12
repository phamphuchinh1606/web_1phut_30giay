<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\EmployeeTimeKeeping;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class EmployeeTimeKeepingRepository extends BaseRepository
{
    public function __construct(EmployeeTimeKeeping $model)
    {
        $this->model = $model;
    }

    public function getEmployeeTotalByMonth($branchId,$date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $month = DateTimeHelper::startOfMonth($date,'Y-m');
        return $this->model::where('branch_id',$branchId)
            ->where('month_date',$month)
            ->get();
    }

    public function getTotalSalaryByMonth($branchId,$date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $month = DateTimeHelper::startOfMonth($date,'Y-m');
        return $this->model::where('branch_id',$branchId)
            ->where('month_date',$month)
            ->sum('salary_amount');
    }

}
