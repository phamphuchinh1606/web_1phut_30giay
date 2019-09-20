<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\SmallCarLocation;
use App\Models\SmallCarLocationOfDay;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SmallCarLocationRepository extends BaseRepository
{
    public function __construct(SmallCarLocation $model)
    {
        $this->model = $model;
    }

    public function selectAllIsShow($currentDate = null){
        $tableSmallCarLocationOfDayName = SmallCarLocationOfDay::getTableName();
        $query = $this->model::where('is_show',1);
        if(isset($currentDate)) {
            $weekNo = DateTimeHelper::dateToWeekNo($currentDate);
            $query->whereNotIn("id", function($query) use ($tableSmallCarLocationOfDayName,$weekNo){
                $query->from("$tableSmallCarLocationOfDayName");
                $query->where('week_no',$weekNo);
                $query->select('small_car_location_id');
            });
        }
        return $query->get();
    }

}
