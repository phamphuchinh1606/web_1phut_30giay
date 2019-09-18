<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\SmallCarLocationRepository;
use Illuminate\Http\Request;

class SmallCarController extends Controller
{
    protected $smallCarLocationRepository;


    public function __construct(SmallCarLocationRepository $smallCarLocationRepository)
    {
        $this->smallCarLocationRepository = $smallCarLocationRepository;
    }

    public function index(){
        $branchId = SessionHelper::getSelectedBranchId();
        $smallCarLocations = $this->smallCarLocationRepository->getByKey(['branch_id' => $branchId]);
        return $this->viewAdmin('smallCar.index',[
            'smallCarLocations' => $smallCarLocations
        ]);
    }

    public function showCreate(){
        return $this->viewAdmin('smallCar.create',[
        ]);
    }
}
