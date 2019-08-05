<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(){
        $vendors = $this->vendorService->getAll();
        return $this->viewAdmin('vendor.index',[
            'vendors' => $vendors
        ]);
    }

    public function showCreate(){
        return $this->viewAdmin('vendor.create');
    }

    public function store(Request $request){
        $vendorName = $request->vendor_name;
        $this->vendorService->create($vendorName);
        return redirect()->route('admin.vendor.index');
    }

    public function showUpdate($id){
        $vendor = $this->vendorService->findId($id);
        return $this->viewAdmin('vendor.update',[
            'vendor' => $vendor
        ]);
    }

    public function update($id, Request $request){
        $vendorName = $request->vendor_name;
        $this->vendorService->update($id, $vendorName);
        return redirect()->route('admin.vendor.index');
    }
}
