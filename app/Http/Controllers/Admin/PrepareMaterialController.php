<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Services\MaterialService;
use Illuminate\Http\Request;

class PrepareMaterialController extends Controller
{
    private $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
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
        $lastDate = $currentDate->addDay(1);
        $result = $this->materialService->getPrepareMaterial($branchId, $lastDate);
        return $this->viewAdmin('prepareMaterial.index',[
            'branchId' => $branchId,
            'currentDate' => $currentDate,
            'materials' => $result['materials'],
            'branches' => $result['branches'],
            'products' => $result['products']
        ]);
    }
}
