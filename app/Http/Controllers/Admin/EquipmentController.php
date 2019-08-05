<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Storage;

class EquipmentController extends Controller
{
    public function index(){
        $products = $this->productService->getAllEquipment();
        return view('admin.equipment.index')->with('products',$products);
    }

    public function showCreate(){
        return view('admin.equipment.create');
    }

    public function store(Request $request){
        $this->productService->createProduct($request);
        return redirect()->route('admin.equipment.index');

    }

    public function showUpdate($id){
        $product = $this->productService->getInfoProduct($id);
        return view('admin.equipment.update',[
            'product' => $product
        ]);
    }

    public function update($id, Request $request){
        $this->productService->updateProduct($id, $request);
        return redirect()->route('admin.equipment.index');
    }

    public function delete($id){
        $this->productService->delete($id);
        return redirect()->route('admin.equipment.index');
    }

    public function addProductImage($productId, Request $request){
        $image = $request->file('image_add');
        if(isset($image)){
            $this->productService->addImage($productId,$image);
        }
        return redirect()->route('admin.equipment.update',['id' => $productId]);
    }

    public function deleteProductImage($productId, $id){
        $this->productService->deleteImage($id);
        return redirect()->route('admin.equipment.update',['id' => $productId]);
    }


}
