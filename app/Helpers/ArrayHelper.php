<?php
namespace App\Helpers;
use App\Common\Constant;

class ArrayHelper{
    public static function parseListObjectToArrayKey($array, $keys, $sperator = '_'){
        $resultArray = [];
        if(isset($array)){
            if(!is_array($keys)) $keys=[$keys];
            foreach ($array as $objectItem){
                $keyArray = null;
                foreach ($keys as $key){
                    $valueItem = null;
                    if(is_array($objectItem)){
                        if(isset($objectItem[$key])){
                            $valueItem = $objectItem[$key];
                        }
                    }else{
                        eval('$valueItem = !isset($objectItem->'.$key.') ? null : $objectItem->'.$key.';');
//                        eval('$valueItem = $objectItem->'.$key.';');
                    }
                    if($keyArray != null ) $keyArray.= $sperator;
                    if(isset($valueItem)) $keyArray.= $valueItem;
                }
                $resultArray[$keyArray] = $objectItem;
            }
        }
        return $resultArray;
    }
}
