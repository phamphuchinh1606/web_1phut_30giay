<?php

namespace App\Http\Controllers\Admin;

use App\Services\ContactService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Services\ProductTypeService;
use App\Services\ProductService;
use App\Services\VendorService;
use App\Services\SettingService;
use App\Services\BlogService;
use App\Services\AddressService;
use App\Services\ManufactureService;
use App\Services\AlbumService;
use App\Services\EquipmentTypeService;
use App\Services\DesignTypeService;
use App\Common\Constant;
use Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function viewAdmin($viewName,$arrayData = []){
        return View('admin.'.$viewName, $arrayData);
    }

    public function uploadImageQuillEditor(Request $request){
        $data = $request->src_image;
        $dataJson = ['status' => 'error',
            'src_image' => ''];
        if(preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches))
        {
            $imageType = $matches[1];
            $imageData = base64_decode($matches[2]);
//            $image = getimagesizefromstring($imageData);
            $filename = time() . '.' . $imageType;
//            $image = file_put_contents($filename,$imageData);
            Storage::put(Constant::$PATH_FOLDER_UPLOAD_IMAGE_EDITOR.'/'.$filename, $imageData);
            $dataJson = ['status' => 'success',
                'src_image' => asset(Constant::$PATH_URL_UPLOAD_IMAGE.Constant::$PATH_FOLDER_UPLOAD_IMAGE_EDITOR.'/'.$filename)];
        } else {
            throw new Exception('Invalid data URL.');
        }
        return response()->json($dataJson);
    }

    public function uploadImage(Request $request){
        $dataJson = ['status' => 'error',
            'src_image' => ''];
        $photos = $request->file('file');

        \Log::info($photos);
        if (!is_array($photos)) {
            $photos = [$photos];
        }
        foreach ($photos as $photo){
            $filename = $photo->getClientOriginalName();
            \Log::info($filename);
            $fileNameUpload = Storage::putFileAs(Constant::$PATH_FOLDER_UPLOAD_IMAGE_DROP, $photo, $filename);
            $dataJson = ['status' => 'success',
                'src_image' => asset(Constant::$PATH_URL_UPLOAD_IMAGE.$fileNameUpload),
                'file_name_upload' => $fileNameUpload
            ];
        }
        return response()->json($dataJson);
    }

    public function deleteImage(Request $request){
        \Log::info($request);
        $dataJson = ['status' => 'error'];
        $fileName = $request->file_name_upload;
        if(isset($fileName)){
            Storage::delete($fileName);
            $dataJson = ['status' => 'success'];
        }
        return response()->json($dataJson);
    }
}
