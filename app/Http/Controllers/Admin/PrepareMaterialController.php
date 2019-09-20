<?php

namespace App\Http\Controllers\Admin;

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
        $result = $this->materialService->getPrepareMaterial($branchId, $lastDate);
        $smallCarLocations = $this->smallCarService->getSmallCarLocationFull($branchId,$lastDate);
        return $this->viewAdmin('prepareMaterial.index',[
            'branchId' => $branchId,
            'currentDate' => $currentDate,
            'lastDate' => $lastDate,
            'materials' => $result['materials'],
            'branches' => $result['branches'],
            'products' => $result['products'],
            'smallCarLocations' => $smallCarLocations
        ]);
    }

    public function updatePrepareMaterial(Request $request){
        $lastDate = DateTimeHelper::dateFromString($request->last_date);
        $branchId = SessionHelper::getSelectedBranchId();
        $values = $request->all();
        $this->materialService->updatePrepareMaterial($values);
        $result = $this->materialService->getPrepareMaterial($branchId, $lastDate);
        return response()
            ->view('admin.prepareMaterial.partials.__prepare_material_content',[
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
        $smallCarLocations = $this->smallCarService->getSmallCarLocationFull($branchId,$lastDate);
        return $this->viewAdmin('prepareMaterial.print_view',[
            'branchId' => $branchId,
            'currentDate' => $currentDate,
            'lastDate' => $lastDate,
            'materials' => $result['materials'],
            'branches' => $result['branches'],
            'products' => $result['products'],
            'smallCarLocations' => $smallCarLocations
        ]);
    }
}
