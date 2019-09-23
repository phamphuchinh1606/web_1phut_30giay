<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Services\MaterialService;
use App\Services\SmallCarService;
use Illuminate\Http\Request;

class PrepareMaterialController extends Controller
{
    private $materialService;
    private $smallCarService;

    public function __construct(MaterialService $materialService, SmallCarService $smallCarService)
    {
        $this->materialService = $materialService;
        $this->smallCarService = $smallCarService;
    }


    public function index($date = null, Request $request){
        $currentDate = SessionHelper::getSelectedMonth()->clone();
        $branchId = SessionHelper::getSelectedBranchId();
        if(isset($date)){
            if(DateTimeHelper::dateFormat($currentDate,'Y-m') != DateTimeHelper::dateFormat(DateTimeHelper::dateFromString($date),'Y-m')){
                return redirect()->route('admin.input_daily');
            }
            $currentDate = DateTimeHelper::dateFromString($date);
        }
        $hour = DateTimeHelper::now()->hour;
        if($hour >= 7){
            $lastDate = $currentDate->addDay(1);
        }else{
            $lastDate = $currentDate;
        }
        if($this->materialService->checkDateIsOfDay($branchId,$lastDate)){
            $lastDate = $lastDate->addDay(1);
        }
        $result = $this->materialService->getPrepareMaterial($branchId, $lastDate);
        $resultSmallLocation = $this->smallCarService->getSmallCarLocationFull($branchId,$lastDate);
        $smallCarLocations = $resultSmallLocation['small_car_locations'];
        return $this->viewEmployee('prepareMaterial.index',[
            'branchId' => $branchId,
            'currentDate' => $currentDate,
            'lastDate' => $lastDate,
            'materials' => $result['materials'],
            'branches' => $result['branches'],
            'products' => $result['products'],
            'smallCarLocations' => $smallCarLocations,
            'total_qty_pepsi' => $resultSmallLocation['total_qty_pepsi'],
            'total_qty_cocoa' => $resultSmallLocation['total_qty_cocoa'],
            'total_qty_milk_tea' => $resultSmallLocation['total_qty_milk_tea'],
            'total_qty_material' => $resultSmallLocation['total_qty_material']
        ]);
    }

    public function updatePrepareMaterial(Request $request){
        $lastDate = DateTimeHelper::dateFromString($request->last_date);
        $branchId = SessionHelper::getSelectedBranchId();
        $values = $request->all();
        $this->materialService->updatePrepareMaterial($values);
        $result = $this->materialService->getPrepareMaterial($branchId, $lastDate);
        return response()
            ->view('employee.prepareMaterial.partials.__prepare_material_content',[
                'branchId' => $branchId,
                'lastDate' => $lastDate,
                'materials' => $result['materials'],
                'branches' => $result['branches'],
                'products' => $result['products']
            ],200)
            ->header('Content-Type','application/html');
    }

    public function printView(Request $request){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $hour = DateTimeHelper::now()->hour;
        if($hour >= 7){
            $lastDate = $currentDate->addDay(1);
        }else{
            $lastDate = $currentDate;
        }
        $result = $this->materialService->getPrepareMaterial($branchId, $lastDate);
        $resultSmallLocation = $this->smallCarService->getSmallCarLocationFull($branchId,$lastDate);
        $smallCarLocations = $resultSmallLocation['small_car_locations'];
        return $this->viewEmployee('prepareMaterial.print_view',[
            'branchId' => $branchId,
            'currentDate' => $currentDate,
            'lastDate' => $lastDate,
            'materials' => $result['materials'],
            'branches' => $result['branches'],
            'products' => $result['products'],
            'smallCarLocations' => $smallCarLocations,
            'total_qty_pepsi' => $resultSmallLocation['total_qty_pepsi'],
            'total_qty_cocoa' => $resultSmallLocation['total_qty_cocoa'],
            'total_qty_milk_tea' => $resultSmallLocation['total_qty_milk_tea'],
            'total_qty_material' => $resultSmallLocation['total_qty_material']
        ]);
    }
}
