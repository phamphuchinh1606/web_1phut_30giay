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
        if(is_double($value)){
            if(preg_match_all('/[\d]+/',doubleval($value), $arrayData) > 1){
                $countDecimal = strlen($arrayData[0][1]);
                return number_format($value,$countDecimal > 2 ? 2 : $countDecimal);
            }
        }
        return number_format($value);
    }
}
