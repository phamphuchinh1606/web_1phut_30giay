<?php
namespace App\Helpers;
use App\Common\Constant;

class AppHelper{
    public static function assetPublic($file){
        $publicPath = Constant::$PATH_FOLDER_PUBLIC;
        return asset("$publicPath/$file");
    }

    public static function formatMoney($value, $nullShowZero = false){
        if(!isset($value) && !$nullShowZero){
            return '';
        }
        return number_format($value);
    }
}
