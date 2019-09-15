<?php

namespace App\Policies;

use App\Common\AuthCommon;
use App\Common\PermissionRoleCommon;
use App\Enums\ScreenEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Models\SettingOfDay;
use App\Repositories\Eloquents\SettingOfDayRepository;
use App\Services\MaterialService;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;

class InputDailyPolicy
{
    use HandlesAuthorization;

    private $materialService;

    private $settingOfDayRepository;

    private static $checkEditInput;

    private static $listOfByWeek;

    private static $listOfByDay;

    public function __construct(MaterialService $materialService, SettingOfDayRepository $settingOfDayRepository)
    {
        $this->materialService = $materialService;
        $this->settingOfDayRepository = $settingOfDayRepository;
    }

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if (PermissionRoleCommon::checkRoleRoot($user)) {
            return true;
        }
    }

    public function canOfDay(Authenticatable $user){
        return false;
    }

    public function view(Authenticatable $user)
    {
        if(AuthCommon::AuthAdmin()->check()){
            return PermissionRoleCommon::checkScreenViewRoleUser($user, ScreenEnum::SCREEN_ADMIN_INPUT_DAILY_URL);
        }
    }

    public function update(Authenticatable $user, $date = null)
    {
        if(AuthCommon::AuthAdmin()->check()){
            $branchId = SessionHelper::getSelectedBranchId();
            if(!PermissionRoleCommon::checkScreenUpdateRoleUser($user, ScreenEnum::SCREEN_ADMIN_INPUT_DAILY_URL)) return false;
            return $this->checkEditFormByDate($branchId,$date) && !$this->checkDateIsOfDay($branchId,$date);
        }else if(AuthCommon::AuthEmployee()->check()){
            $branchId = SessionHelper::getSelectedBranchId();
            if(!PermissionRoleCommon::checkScreenUpdateRoleUser($user, ScreenEnum::SCREEN_INPUT_DAILY_URL)) return false;
            return $this->checkEditFormByDate($branchId,$date) && !$this->checkDateIsOfDay($branchId,$date);
        }
    }

    private function checkEditFormByDate($branchId,$date){
        if(!isset($date)) return true;
        if(isset(self::$checkEditInput)) return self::$checkEditInput;

        $currentDate = DateTimeHelper::now();
        for($i = 1 ; $i < 10 ; $i ++){
            if(!$this->checkDateIsOfDay($branchId,$currentDate)){
                self::$checkEditInput = (DateTimeHelper::truncateTime($currentDate->addDay(-1)) <=  DateTimeHelper::truncateTime($date));
                return self::$checkEditInput;
            }
            $currentDate = $currentDate->addDay(-1);
        }
        self::$checkEditInput = false;
        return self::$checkEditInput;
    }

    private function checkDateIsOfDay($branchId,$date){
        if(!isset(self::$listOfByWeek)){
            self::$listOfByWeek = $this->settingOfDayRepository->getByKey(array('branch_id' => $branchId, 'type_day' => SettingOfDay::TYPE_OFF_WEEK));
        }

        if(!isset(self::$listOfByDay)){
            self::$listOfByDay = $this->settingOfDayRepository->getByKey(array('branch_id' => $branchId, 'type_day' => SettingOfDay::TYPE_OFF_DAY));
        }

        $weekNo = DateTimeHelper::dateToWeekNo($date);
        foreach (self::$listOfByWeek as $ofWeek){
            if($ofWeek->week_no == $weekNo){
                return true;
            }
        }
        foreach (self::$listOfByDay as $ofDay){
            if(DateTimeHelper::dateFormat($ofDay->date_off,'Y-m-d') == DateTimeHelper::dateFormat($date,'Y-m-d')){
                return true;
            }
        }

        return false;
    }
}
