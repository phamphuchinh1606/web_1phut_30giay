<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Models\OrderCheckIn;
use App\Repositories\Eloquents\OrderCheckInRepository;
use App\Services\CheckInService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    protected $checkInService;
    protected $checkInRepository;

    public function __construct(CheckInService $checkInService, OrderCheckInRepository $orderCheckInRepository)
    {
        $this->checkInService = $checkInService;
        $this->checkInRepository = $orderCheckInRepository;
    }

    public function daily(Request $request){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $result = $this->checkInService->getCheckInByMonth($branchId,$currentDate);
        return $this->viewAdmin('checkin.check_in_daily',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'infoDays' => $result['infoDays'],
            'suppliers' => $result['suppliers']
        ]);
    }

    public function checkInCharge($id = null, Request $request){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        if(isset($id)){
            $checkIn = $this->checkInRepository->find($id);
        }else{
            $checkIn = new OrderCheckIn();
            $checkIn->qty = 1;
            $checkIn->price = 0;
            $checkIn->amount = 0;
        }
        $checkIns = $this->checkInRepository->listCheckInByType(OrderCheckIn::arrayTypeCheckInCharge(), $branchId, $currentDate);
        return $this->viewAdmin('checkin.check_in_charge',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'checkIn' => $checkIn,
            'checkIns' => $checkIns
        ]);
    }

    public function createCheckInCharge(Request $request){
        $input = $request->all();
        $this->checkInRepository->create($input);
        return redirect()->route('admin.check_in.check_in_charge')->with('message','Thêm mới thành công');
    }

    public function updateCheckInCharge($id, Request $request){
        $inputs = $request->all();
        $inputs = array_merge($inputs,['id' => $id]);
        $this->checkInRepository->update($inputs);
        return redirect()->route('admin.check_in.check_in_charge')->with('message','Cập nhật thành công');
    }

    public function delete($id){
        $this->checkInRepository->deleteLogic(array('id' => $id));
        return redirect()->route('admin.check_in.check_in_charge')->with('message','Xóa Thành Công');
    }
}
