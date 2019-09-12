<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SessionHelper;
use App\Models\Finance;
use App\Repositories\Eloquents\FinanceRepository;
use App\Services\FinanceService;
use Illuminate\Http\Request;
class FinanceController extends Controller
{
    protected $financeRepository;
    protected $financeService;

    public function __construct(FinanceRepository $financeRepository, FinanceService $financeService)
    {
        $this->financeRepository = $financeRepository;
        $this->financeService = $financeService;
    }

    public function index($id = null,Request $request){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $finances = $this->financeRepository->getList($branchId,$currentDate);
        if(isset($id)){
            $finance = $this->financeRepository->find($id);
        }else{
            $finance = new Finance();
            $finance->amount_in = 0;
            $finance->amount_out = 0;
        }
        $totalAmountIn = 0;
        $totalAmountOut = 0;
        foreach ($finances as $financeItem){
            $totalAmountIn+= $financeItem->amount_in;
            $totalAmountOut+= $financeItem->amount_out;
        }
        return $this->viewAdmin('finance.finance',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'finances' => $finances,
            'finance' => $finance,
            'totalAmountIn' => $totalAmountIn,
            'totalAmountOut' => $totalAmountOut
        ]);
    }

    public function getFinanceSaleAmount(Request $request){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $this->financeService->getFinanceSaleAmount($branchId,$currentDate);
        return redirect()->route('admin.finance')->with('message','Đã lấy thành công');
    }

    public function create(Request $request){
        $input = $request->all();
        $this->financeRepository->create($input);
        return redirect()->route('admin.finance')->with('message','Đã thêm thành công');
    }

    public function update($id, Request $request){
        $inputs = $request->all();
        $inputs = array_merge($inputs,['id' => $id]);
        $this->financeRepository->update($inputs);
        return redirect()->route('admin.finance')->with('message','Cập Nhật Thành Công');
    }

    public function delete($id){
        $this->financeRepository->deleteLogic(array('id' => $id));
        return redirect()->route('admin.finance')->with('message','Xóa Thành Công');
    }
}
