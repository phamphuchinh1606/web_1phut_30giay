<?php
namespace App\Helpers;
use Storage;
use Illuminate\Http\UploadedFile;
use App\Common\Constant;

class ImageHelper{

    public static function moveImageLogo(UploadedFile $file){
        if(isset($file)){
            $filename = time().'_'.$file->getClientOriginalName();
            $pathImage = Storage::putFileAs('',$file,$filename);
            return $pathImage;
        }
        return "";
    }

    public static function moveImage(UploadedFile $file, $pathFolder){
        if(isset($file)){
            $filename = time().'_'.$file->getClientOriginalName();
            $fileNameUpload = Storage::putFileAs($pathFolder, $file, $filename);
            return $fileNameUpload;
        }
        return "";
    }

    public static function moveImageProduct(UploadedFile $file, $productId){
        return self::moveImage($file, Constant::$PATH_FOLDER_UPLOAD_PRODUCT.'/'.$productId);
    }

    public static function deleteImageLogo($fileNameLogo){
        $pathFile = public_path(). $fileNameLogo;
        if(file_exists($pathFile)){
            unlink($pathFile);
        }
    }

    public static function deleteImage($imageName){
        if(Storage::exists($imageName)){
            Storage::delete($imageName);
        }
    }

    public static function showImage($image){
        return asset(Constant::$PATH_URL_UPLOAD_IMAGE.$image);
    }
}
