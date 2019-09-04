<?php

namespace App\Policies;

use App\Common\AuthCommon;
use App\Common\PermissionRoleCommon;
use App\Enums\ScreenEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Services\MaterialService;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;

class InputDailyPolicy
{
    use HandlesAuthorization;

    private $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
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

    public function view(Authenticatable $user)
    {
//        return true;
        if(AuthCommon::AuthAdmin()->check()){
            return PermissionRoleCommon::checkScreenViewRoleUser($user, ScreenEnum::SCREEN_ADMIN_INPUT_DAILY_URL);
        }
    }

    public function update(Authenticatable $user, $date = null)
    {
        if(AuthCommon::AuthAdmin()->check()){
            if(!PermissionRoleCommon::checkScreenUpdateRoleUser($user, ScreenEnum::SCREEN_ADMIN_INPUT_DAILY_URL)) return false;
            return $this->checkEditFormByDate($date);
        }
    }

    private function checkEditFormByDate($date){
        if(!isset($date)) return true;
        $currentDate = DateTimeHelper::now();
        $branchId = SessionHelper::getSelectedBranchId();
        for($i = 1 ; $i < 10 ; $i ++){
            if(!$this->materialService->checkDateIsOfDay($branchId,$currentDate)){
                return (DateTimeHelper::truncateTime($currentDate->addDay(-1)) <=  DateTimeHelper::truncateTime($date));
            }
            $currentDate = $currentDate->addDay(-1);
        }
        return false;
    }
}
