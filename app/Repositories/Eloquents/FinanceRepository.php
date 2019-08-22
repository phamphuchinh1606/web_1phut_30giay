<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\Finance;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class FinanceRepository extends BaseRepository
{
    public function __construct(Finance $model)
    {
        $this->model = $model;
    }

    public function getList($branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('date_daily', '>=' , $firstDate)
            ->where('date_daily', '<=', $lastDate)
            ->orderBy('date_daily','desc')->get();
    }

}
