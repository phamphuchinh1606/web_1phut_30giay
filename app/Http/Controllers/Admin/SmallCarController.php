<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\SmallCarLocationRepository;
use App\Repositories\Eloquents\SmallCarProductRepository;
use Illuminate\Http\Request;

class SmallCarController extends Controller
{
    protected $smallCarLocationRepository;
    protected $smallCarProductRepository;
    protected $materialRepository;
    protected $productRepository;

    public function __construct(SmallCarLocationRepository $smallCarLocationRepository, SmallCarProductRepository $smallCarProductRepository,
                                MaterialRepository $materialRepository, ProductRepository $productRepository)
    {
        $this->smallCarLocationRepository = $smallCarLocationRepository;
        $this->smallCarProductRepository = $smallCarProductRepository;
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
        return $this->viewAdmin('smallCar.create',[
            'products' => $products
        ]);
    }
}
