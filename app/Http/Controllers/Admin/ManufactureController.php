<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class ManufactureController extends Controller
{
    public function manufactureList(){
        $manufactures = $this->manufactureService->getManufactureAll();
        return $this->viewAdmin('manufacture.manufacture',[
            'manufactures' => $manufactures
        ]);
    }

    public function manufactureCreate(Request $request){
        $this->manufactureService->createManufacture($request);
        return redirect()->route('admin.manufacture.index');
    }

    public function manufactureDestroy($id){
        $this->manufactureService->deleteManufacture($id);
        return redirect()->route('admin.manufacture.index');
    }
}
