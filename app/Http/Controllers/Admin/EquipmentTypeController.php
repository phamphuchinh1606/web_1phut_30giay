<?php

namespace App\Http\Controllers\Admin;

use App\Common\Constant;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function index(){
        $listEquipmentType = $this->equipmentService->getAllNotParent();
        return $this->viewAdmin('equipmentType.index',[
            'listEquipmentType' => $listEquipmentType
        ]);
    }

    public function showCreate(){
        return $this->viewAdmin('equipmentType.create');
    }

    private function getIsPulic($request){
        $isPublic = Constant::$PUBLIC_FLG_ON;
        if($request->is_public == "Off" || $request->is_public == null){
            $isPublic = Constant::$PUBLIC_FLG_OFF;
        }
        return $isPublic;
    }

    public function store(Request $request){
        $equipmentType = $this->equipmentService->create($request);
        if(isset($equipmentType->id)){
            return redirect()->route('admin.equipment_type.update',['id' => $equipmentType->id]);
        }
        return redirect()->route('admin.equipment_type.index');
    }

    public function showUpdate($id){
        $equipmentType = $this->equipmentService->findId($id);
        if($equipmentType->is_public == Constant::$PUBLIC_FLG_ON){
            $equipmentType->is_check_public = "checked='checked'";
        }
        $listChildren = $this->equipmentService->getByParentId($id);
        return $this->viewAdmin('equipmentType.update',[
            'equipmentType' => $equipmentType,
            'listChildren' => $listChildren
        ]);
    }

    public function update($id,Request $request){
        $this->equipmentService->update($id,$request);
        return redirect()->route('admin.equipment_type.index');
    }

    public function createProductTypeChildren($id,Request $request){
        $equipmentTypeName = $request->product_type_name;
        $isPublic = $this->getIsPulic($request);
        $this->equipmentService->createChildren($id,$equipmentTypeName,$isPublic);
        return redirect()->route('admin.equipment_type.update',['id' => $id]);
    }

    public function deleteProductTypeChildren($id,$childId){
        $this->equipmentService->delete($childId);
        return redirect()->route('admin.equipment_type.update',['id' => $id]);
    }
}
