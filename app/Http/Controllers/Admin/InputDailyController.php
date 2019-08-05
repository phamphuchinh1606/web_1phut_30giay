<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Services\MaterialService;
use Illuminate\Http\Request;

class InputDailyController extends Controller
{
    private $materialService;

    private $materialTypeRepository;

    public function __construct(MaterialService $materialService, MaterialTypeRepository $materialTypeRepository)
    {
        $this->materialService = $materialService;

        $this->materialTypeRepository = $materialTypeRepository;
    }

    public function index(){
        $currentDate = DateTimeHelper::now();
        $materialTypes = $this->materialTypeRepository->selectAll();
        return $this->viewAdmin('input.input_daily',[
            'currentDate' => $currentDate,
            'materialTypes' => $materialTypes
        ]);
    }
}
