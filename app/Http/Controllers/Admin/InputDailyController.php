<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Models\SettingOfDay;
use App\Repositories\Eloquents\EmployeeDailyRepository;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\OrderBillRepository;
use App\Repositories\Eloquents\OrderCheckInRepository;
use App\Repositories\Eloquents\OrderCheckOutRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\SaleRepository;
use App\Repositories\Eloquents\SettingOfDayRepository;
use App\Services\MaterialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InputDailyController extends Controller
{
    private $materialService;

    private $materialRepository;

    private $materialTypeRepository;

    private $employeeRepository;

    private $employeeDailyRepository;

    private $productRepository;

    private $orderCheckInRepository;

    private $orderCheckOutRepository;

    private $saleRepository;

    private $orderBillRepository;

    private $settingOfDayRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, EmployeeRepository $employeeRepository,
        ProductRepository $productRepository, OrderCheckInRepository $orderCheckInRepository, MaterialService $materialService, SaleRepository $saleRepository,
        OrderBillRepository $orderBillRepository, EmployeeDailyRepository $employeeDailyRepository, OrderCheckOutRepository $orderCheckOutRepository,
        SettingOfDayRepository $settingOfDayRepository)
    {
        $this->materialService = $materialService;
        $this->materialRepository = $materialRepository;
        $this->materialTypeRepository = $materialTypeRepository;
        $this->employeeRepository = $employeeRepository;
        $this->employeeDailyRepository = $employeeDailyRepository;
        $this->productRepository = $productRepository;
        $this->orderCheckInRepository = $orderCheckInRepository;
        $this->orderCheckOutRepository = $orderCheckOutRepository;
        $this->saleRepository = $saleRepository;
        $this->orderBillRepository = $orderBillRepository;
        $this->settingOfDayRepository = $settingOfDayRepository;
    }

    public function index($date = null, Request $request){
        $currentDate = SessionHelper::getSelectedMonth();
        if(isset($date)){
            if(DateTimeHelper::dateFormat($currentDate,'Y-m') != DateTimeHelper::dateFormat(DateTimeHelper::dateFromString($date),'Y-m')){
                return redirect()->route('admin.input_daily');
            }
            $currentDate = DateTimeHelper::dateFromString($date);
        }
        $branchId = SessionHelper::getSelectedBranchId();
        $infoDays = DateTimeHelper::getArrayDateByCurrentDate(SessionHelper::getSelectedMonth());
        $materialTypes = $this->materialTypeRepository->selectAll();
        $materials = $this->materialRepository->getAllByFormInput($branchId,$currentDate);
        $employees = $this->employeeRepository->getEmployeeDaily($branchId,$currentDate);
        $sumEmployeeTotal = $this->employeeDailyRepository->sumTotalDaily($branchId,$currentDate);
        $products = $this->productRepository->selectProductMergeSales($branchId,$currentDate);
        $sales = $this->saleRepository->findByKey(array('branch_id' => $branchId,'sale_date' => $currentDate->format('Y-m-d')));
        $orderBill = $this->orderBillRepository->findByKeyOrCreate(array('branch_id' => $branchId,'bill_date' => $currentDate->format('Y-m-d')));
        $totalAmountCheckIn = $this->orderCheckInRepository->getTotalAmountByDate($branchId,$currentDate);
        $totalAmountCheckOut = $this->orderCheckOutRepository->getTotalAmountByDate($branchId,$currentDate);
        $totalQty = 0;
        foreach ($products as $product){
            if(isset($product->qty)){
                $totalQty+= $product->qty;
            }
        }
        $isOfDay = $this->materialService->checkDateIsOfDay($branchId,$currentDate);
        return $this->viewAdmin('input.input_daily',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'infoDays' => $infoDays,
            'materialTypes' => $materialTypes,
            'materials' => $materials,
            'employees' => $employees,
            'sumEmployeeTotal' => $sumEmployeeTotal,
            'products' => $products,
            'sales' => $sales,
            'orderBill' => $orderBill,
            'totalAmountCheckIn' => $totalAmountCheckIn,
            'totalAmountCheckOut' => $totalAmountCheckOut,
            'totalQty' => $totalQty,
            'editForm' => $this->checkEditFormByDate($branchId,$currentDate) ? 1 : 0,
            'isOfDay' => $isOfDay
        ]);
    }

    public function updateDaily(Request $request){
        $values = $request->all();
        $values['branch_id'] = SessionHelper::getSelectedBranchId();
        $resultQty = $this->materialService->updateInputDaily($values);
        return response()->json($resultQty);
    }

    public function updateSale(Request $request){
        $values = $request->all();
        $values['branch_id'] = SessionHelper::getSelectedBranchId();
        $resultQty = $this->materialService->updateSale($values);
        return response()->json($resultQty);
    }

    public function updateBill(Request $request){
        $values = $request->all();
        $values['branch_id'] = SessionHelper::getSelectedBranchId();
        $resultQty = $this->materialService->updateBill($values);
        return response()->json($resultQty);
    }

    public function updateEmployee(Request $request){
        $values = $request->all();
        $values['branch_id'] = SessionHelper::getSelectedBranchId();
        $resultQty = $this->materialService->updateEmployee($values);
        return response()->json($resultQty);
    }

    private function checkEditFormByDate($branchId,$date){
        $currentDate = DateTimeHelper::now();
        for($i = 1 ; $i < 10 ; $i ++){
            if(!$this->materialService->checkDateIsOfDay($branchId,$currentDate)){
                return (DateTimeHelper::truncateTime($currentDate->addDay(-1)) <=  DateTimeHelper::truncateTime($date));
            }
            $currentDate = $currentDate->addDay(-1);
        }
        return false;
    }

    public function updateOfDay($date, Request $request){
        if(isset($date)){
            $branchId = SessionHelper::getSelectedBranchId();
            $this->materialService->updateOfDay($branchId,$date);
            return redirect()->route('admin.input_daily',['date' => $date])->with('message','Đã cặp nhật thành công');
        }
        return redirect()->route('admin.input_daily')->with('message','Đã cặp nhật thành công');
    }
}
