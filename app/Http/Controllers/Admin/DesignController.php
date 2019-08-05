<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Storage;

class DesignController extends Controller
{
    public function index(){
        $products = $this->productService->getAllDesign();
        return view('admin.design.index')->with('products',$products);
    }

    public function showCreate(){
        return view('admin.design.create');
    }

    public function store(Request $request){
        $this->productService->createProduct($request);
        return redirect()->route('admin.design.index');

    }

    public function showUpdate($id){
        $product = $this->productService->getInfoProduct($id);
        return view('admin.design.update',[
            'product' => $product
        ]);
    }

    public function update($id, Request $request){
        $this->productService->updateProduct($id, $request);
        return redirect()->route('admin.design.index');
    }

    public function delete($id){
        $this->productService->delete($id);
        return redirect()->route('admin.design.index');
    }

    public function addProductImage($productId, Request $request){
        $image = $request->file('image_add');
        if(isset($image)){
            $this->productService->addImage($productId,$image);
        }
        return redirect()->route('admin.design.update',['id' => $productId]);
    }

    public function deleteProductImage($productId, $id){
        $this->productService->deleteImage($id);
        return redirect()->route('admin.design.update',['id' => $productId]);
    }


}
