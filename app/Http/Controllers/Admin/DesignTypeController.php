<?php

namespace App\Http\Controllers\Admin;

use App\Common\Constant;
use Illuminate\Http\Request;

class DesignTypeController extends Controller
{
    public function index(){
        $listDesignType = $this->designService->getAllNotParent();
        return $this->viewAdmin('designType.index',[
            'listDesignType' => $listDesignType
        ]);
    }

    public function showCreate(){
        return $this->viewAdmin('designType.create');
    }

    private function getIsPulic($request){
        $isPublic = Constant::$PUBLIC_FLG_ON;
        if($request->is_public == "Off" || $request->is_public == null){
            $isPublic = Constant::$PUBLIC_FLG_OFF;
        }
        return $isPublic;
    }

    public function store(Request $request){
        $designType = $this->designService->create($request);
        if(isset($designType->id)){
            return redirect()->route('admin.design_type.update',['id' => $designType->id]);
        }
        return redirect()->route('admin.design_type.index');
    }

    public function showUpdate($id){
        $designType = $this->designService->findId($id);
        if($designType->is_public == Constant::$PUBLIC_FLG_ON){
            $designType->is_check_public = "checked='checked'";
        }
        $listChildren = $this->designService->getByParentId($id);
        return $this->viewAdmin('designType.update',[
            'designType' => $designType,
            'listChildren' => $listChildren
        ]);
    }

    public function update($id,Request $request){
        $this->designService->update($id,$request);
        return redirect()->route('admin.design_type.index');
    }

    public function createProductTypeChildren($id,Request $request){
        $designTypeName = $request->product_type_name;
        $isPublic = $this->getIsPulic($request);
        $this->designService->createChildren($id,$designTypeName,$isPublic);
        return redirect()->route('admin.design_type.update',['id' => $id]);
    }

    public function deleteProductTypeChildren($id,$childId){
        $this->designService->delete($childId);
        return redirect()->route('admin.design_type.update',['id' => $id]);
    }
}
