<?php

namespace App\Repositories\Eloquents;

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
        return $this->model::where('branch_id',$branchId)
            ->where('date_daily',$date)
            ->selectRaw("sum(first_hours) as first_hours_total, sum(last_hours) as last_hours_total, 
                sum(first_hours*price_first_hour) as amount_first_hour_total, sum(last_hours*price_last_hour) as amount_last_hour_total")
            ->get();
    }

}
