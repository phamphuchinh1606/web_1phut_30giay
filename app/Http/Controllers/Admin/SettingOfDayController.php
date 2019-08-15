<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Repositories\Eloquents\SettingOfDayRepository;
use Illuminate\Http\Request;

class SettingOfDayController extends Controller
{
    private $settingOfDayRepository;

    public function __construct(SettingOfDayRepository $settingOfDayRepository)
    {
        $this->settingOfDayRepository = $settingOfDayRepository;
    }

    public function index(){
        $branchId = 1;
        $weekMap = DateTimeHelper::getWeekArray();
        $settingOfDays = $this->settingOfDayRepository->findByKey(array('branch_id' => $branchId));
        return $this->viewAdmin('setting.setting_of_day',[
            'branchId' => $branchId,
            'settingOfDays' => $settingOfDays,
            'weekMap' => $weekMap
        ]);
    }
}
