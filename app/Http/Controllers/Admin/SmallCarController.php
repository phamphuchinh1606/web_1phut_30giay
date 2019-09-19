<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\SmallCarLocationRepository;
use App\Repositories\Eloquents\SmallCarMaterialRepository;
use App\Repositories\Eloquents\SmallCarProductRepository;
use App\Services\SmallCarService;
use Illuminate\Http\Request;

class SmallCarController extends Controller
{
    protected $smallCarLocationRepository;
    protected $smallCarProductRepository;
    protected $smallCarMaterialRepository;
    protected $smallCarService;
    protected $materialRepository;
    protected $productRepository;

    public function __construct(SmallCarLocationRepository $smallCarLocationRepository, SmallCarProductRepository $smallCarProductRepository,
                                SmallCarMaterialRepository $smallCarMaterialRepository, MaterialRepository $materialRepository,
                                ProductRepository $productRepository, SmallCarService $smallCarService)
    {
        $this->smallCarLocationRepository = $smallCarLocationRepository;
        $this->smallCarProductRepository = $smallCarProductRepository;
        $this->smallCarMaterialRepository = $smallCarMaterialRepository;
        $this->smallCarService = $smallCarService;
        $this->materialRepository = $materialRepository;
        $this->productRepository = $productRepository;
    }

    public function index(){
        $branchId = SessionHelper::getSelectedBranchId();
        $smallCarLocations = $this->smallCarLocationRepository->getByKey(['branch_id' => $branchId]);
        return $this->viewAdmin('smallCar.index',[
            'smallCarLocations' => $smallCarLocations
        ]);
    }

    public function showCreate(){
        $branchId = SessionHelper::getSelectedBranchId();
        $products = $this->smallCarProductRepository->getSmallCarProduct($branchId);
        $materials = $this->smallCarMaterialRepository->getSmallCarMaterial($branchId);
        return $this->viewAdmin('smallCar.create',[
            'branchId' => $branchId,
            'products' => $products,
            'materials' => $materials
        ]);
    }

    public function create(Request $request){
        $values = $request->all();
        $this->smallCarService->createSmallCarLocation($values);
        return redirect()->route('admin.setting.small_car')->with('message','Tạo Mới Thành Công');
    }

    public function showUpdate($id, Request $request){
        $smallCarLocation = $this->smallCarLocationRepository->find($id);
        if($smallCarLocation->is_show == 1){
            $smallCarLocation->is_show_check = "checked='checked'";
        }
        $branchId = SessionHelper::getSelectedBranchId();
        $products = $this->smallCarProductRepository->getSmallCarProduct($branchId,$id);
        $materials = $this->smallCarMaterialRepository->getSmallCarMaterial($branchId);
        return $this->viewAdmin('smallCar.update',[
            'branchId' => $branchId,
            'smallCarLocation' => $smallCarLocation,
            'products' => $products,
            'materials' => $materials
        ]);
    }

    public function update($id, Request $request){
        $values = $request->all();
        $values['id'] = $id;
        $values['branch_id'] = SessionHelper::getSelectedBranchId();
        $this->smallCarService->updateSmallCarLocation($values);
        return redirect()->route('admin.setting.small_car')->with('message','Tạo Mới Thành Công');
    }
}
