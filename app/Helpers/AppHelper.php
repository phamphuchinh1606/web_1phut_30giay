<?php
namespace App\Helpers;
use App\Common\Constant;

class AppHelper{
    public static function assetPublic($file){
        $publicPath = Constant::$PATH_FOLDER_PUBLIC;
        return asset("$publicPath/$file");
    }

    public static function valueSwitch($value){
        if (isset($value) && $value == Constant::SWITCH_FLG_ON) {
            return 1;
        }
        return 0;
    }

    public static function formatMoney($value, $nullShowZero = false){
        if(!isset($value) && !$nullShowZero){
            return '';
        }
        if(is_double($value) || is_float($value) || doubleval($value) || floatval($value)){
            if(preg_match_all('/[\d]+/',doubleval($value), $arrayData) > 1){
                $countDecimal = strlen($arrayData[0][1]);
                return number_format($value,$countDecimal > 2 ? 2 : $countDecimal);
            }
        }
        return number_format($value);
    }
}
