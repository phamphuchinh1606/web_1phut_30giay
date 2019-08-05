<?php

namespace App\Http\Controllers\Admin;

use App\Common\Constant;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index(){
        $listProductType = $this->productTypeService->getAllNotParent();
        return $this->viewAdmin('productType.index',[
            'listProductType' => $listProductType
        ]);
    }

    public function showCreate(){
        return $this->viewAdmin('productType.create');
    }

    private function getIsPulic($request){
        $isPublic = Constant::$PUBLIC_FLG_ON;
        if($request->is_public == "Off" || $request->is_public == null){
            $isPublic = Constant::$PUBLIC_FLG_OFF;
        }
        return $isPublic;
    }

    public function store(Request $request){
        $productType = $this->productTypeService->create($request);
        if(isset($productType->id)){
            return redirect()->route('admin.product_type.update',['id' => $productType->id]);
        }
        return redirect()->route('admin.product_type.index');
    }

    public function showUpdate($id){
        $productType = $this->productTypeService->findId($id);
        if($productType->is_public == Constant::$PUBLIC_FLG_ON){
            $productType->is_check_public = "checked='checked'";
        }
        $listChildren = $this->productTypeService->getByParentId($id);
        return $this->viewAdmin('productType.update',[
            'productType' => $productType,
            'listChildren' => $listChildren
        ]);
    }

    public function update($id,Request $request){
        $this->productTypeService->update($id,$request);
        return redirect()->route('admin.product_type.index');
    }

    public function createProductTypeChildren($id,Request $request){
        $productTypeName = $request->product_type_name;
        $isPublic = $this->getIsPulic($request);
        $this->productTypeService->createChildren($id,$productTypeName,$isPublic);
        return redirect()->route('admin.product_type.update',['id' => $id]);
    }

    public function deleteProductTypeChildren($id,$childId){
        $this->productTypeService->delete($childId);
        return redirect()->route('admin.product_type.update',['id' => $id]);
    }
}
