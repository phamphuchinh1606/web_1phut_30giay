<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Models\SettingOfDay;
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
        $listOfDay = $this->settingOfDayRepository->getByKey(array('branch_id' => $branchId));
        $settingWeekOfDays = [];
        $settingOfDays = [];
        foreach ($listOfDay as $settingOfDay){
            if(SettingOfDay::TYPE_OFF_WEEK == $settingOfDay->type_day){
                $settingWeekOfDays[] = $settingOfDay;
            }else{
                $settingOfDays[] = $settingOfDay;
            }
        }
        return $this->viewAdmin('setting.setting_of_day',[
            'branchId' => $branchId,
            'settingWeekOfDays' => $settingWeekOfDays,
            'settingOfDays' => $settingOfDays,
            'weekMap' => $weekMap
        ]);
    }

    public function saveSettingDay(Request $request){
        $branchId = 1;
        $typeDay = $request->type_day;
        if(SettingOfDay::TYPE_OFF_WEEK == $typeDay){
            $this->settingOfDayRepository->deleteLogic(array(
                'branch_id' => $branchId,
                'type_day' => $typeDay,
            ));
            $weekSelected = $request->check_week;
            foreach ($weekSelected as $week){
                $this->settingOfDayRepository->updateOrCreate(array('week_no' => $week),array(
                    'branch_id' => $branchId,
                    'type_day' => $typeDay,
                    'week_no' => $week
                ));
            }
        }else{
            $this->settingOfDayRepository->updateOrCreate($request->all(),array(
                'branch_id' => $branchId,
                'type_day' => $typeDay,
                'date_off' => $request->date_off
            ));
        }
        return redirect()->route('admin.setting.setting_of_day')->with('message','Đã cập nhật ngày nghĩ thành công');
    }

    public function deleteSettingDay($id){
        $this->settingOfDayRepository->deleteLogic(array('id' => $id));
        return redirect()->route('admin.setting.setting_of_day')->with('message','Xóa Thành Công');
    }
}
