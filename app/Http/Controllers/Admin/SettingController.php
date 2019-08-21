<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function updateSelectedBranch(Request $request){
        $branchId = $request->branch_id;
        if(isset($branchId)){
            SessionHelper::setSelectedBranchId($branchId);
            return $this->jsonSuccess();
        }
        return $this->jsonError();
    }

    public function updateSelectedMonth(Request $request){
        $month = $request->month;
        if(isset($month)){
            SessionHelper::setSelectedMonth(DateTimeHelper::dateFromString($month));
            return $this->jsonSuccess();
        }
        return $this->jsonError();
    }
}
