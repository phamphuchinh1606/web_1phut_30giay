<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\MaterialRepository;
use App\Services\DashboardService;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class MaterialController extends Controller
{
    protected $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function index(){
        $materials = $this->materialRepository->selectAll();
        return $this->viewAdmin('material.index',[
            'materials' => $materials,
        ]);
    }
}
