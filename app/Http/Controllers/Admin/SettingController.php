<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function updateSelectedBranch(Request $request){
        $branchId = $request->branch_id;
        $branchName = $request->branch_name;
        if(isset($branchId)){
            SessionHelper::setSelectedBranchId($branchId);
            SessionHelper::setSelectedBranchName($branchName);
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

    public function showSettingApp(){
        $branchId = SessionHelper::getSelectedBranchId();
        $settingApp = $this->settingRepository->findByKey(['branch_id' => $branchId]);
        if(!isset($settingApp)) $settingApp = $this->settingRepository->create(['branch_id' => $branchId]);

        return $this->viewAdmin('setting.setting_app',[
            'branchId' => $branchId,
            'settingApp' => $settingApp
        ]);
    }

    public function updateSettingApp(Request $request){
        $branchId = SessionHelper::getSelectedBranchId();
        $settingApp = $this->settingRepository->findByKey(['branch_id' => $branchId]);
        if(isset($settingApp)) {
            $this->settingRepository->update(array_merge(['id' => $settingApp->id], $request->all()));
        }
        return redirect()->route('admin.setting.setting_app')->with('message','Cập Nhật Thành Công');
    }
}
