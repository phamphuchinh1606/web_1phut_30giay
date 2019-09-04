<?php

namespace App\Http\Controllers\Admin;

use App\Common\Constant;
use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\SupplierRepository;
use App\Repositories\Eloquents\UnitRepository;
use App\Services\DashboardService;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class MaterialController extends Controller
{
    protected $materialRepository;
    protected $materialTypeRepository;
    protected $unitRepository;
    protected $supplierRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, UnitRepository $unitRepository,
            SupplierRepository $supplierRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->materialTypeRepository = $materialTypeRepository;
        $this->unitRepository = $unitRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function index(){
        $materials = $this->materialRepository->selectAll();
        return $this->viewAdmin('material.index',[
            'materials' => $materials,
        ]);
    }

    public function showCreate(){
        $materialTypes = $this->materialTypeRepository->selectAll();
        $units = $this->unitRepository->selectAll();
        $suppliers = $this->supplierRepository->selectAll();
        return $this->viewAdmin('material.create',[
            'materialTypes' => $materialTypes,
            'units' => $units,
            'suppliers' => $suppliers
        ]);
    }

    public function create(Request $request){
        $values = $request->all();
        if(isset($values['is_show_input']) && $values['is_show_input'] == Constant::SWITCH_FLG_ON){
            $values['is_show_input'] = 1;
        }else{
            $values['is_show_input'] = 0;
        }
        $this->materialRepository->create($values);
        return redirect()->route('admin.material')->with('message','Cập Nhật Thành Công');
    }

    public function showUpdate($id){
        $materialTypes = $this->materialTypeRepository->selectAll();
        $units = $this->unitRepository->selectAll();
        $suppliers = $this->supplierRepository->selectAll();
        $material = $this->materialRepository->find($id);
        if($material->is_show_input == 1){
            $material->is_check_show_input = "checked='checked'";
        }
        return $this->viewAdmin('material.update',[
            'material' => $material,
            'materialTypes' => $materialTypes,
            'units' => $units,
            'suppliers' => $suppliers
        ]);
    }

    public function update($id, Request $request){
        $values = $request->all();
        $values['id'] = $id;
        if(isset($values['is_show_input']) && $values['is_show_input'] == Constant::SWITCH_FLG_ON){
            $values['is_show_input'] = 1;
        }else{
            $values['is_show_input'] = 0;
        }
        $this->materialRepository->update($values);
        return redirect()->route('admin.material')->with('message','Cập Nhật Thành Công');
    }

    public function delete($id){
        $this->materialRepository->deleteLogic(['id' => $id]);
        return redirect()->route('admin.material')->with('message','Xóa Thành Công');
    }
}
