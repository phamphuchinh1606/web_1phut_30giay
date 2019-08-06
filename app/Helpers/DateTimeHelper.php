<?php
namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper{

    /**
     * Get default TimeZone
     *
     * @return \DateTimeZone
     */
    public static function timezone()
    {
        return new \DateTimeZone("Asia/Ho_Chi_Minh");
    }

    /**
     * Get Current DateTime
     *
     * @return \DateTime
     */
    public static function now()
    {
        return new \DateTime('now', static::timezone());
    }

    public static function dateFormat($value, $format = "d-m-Y H:i"){
        return Carbon::parse($value,self::timezone())->format($format);
    }

    public static function startOfMonth($format = null){
        if(isset($format)){
            return self::now()->startOfMonth()->format($format);
        }
        return self::now()->startOfMonth();
    }

    public static function endOfMonth($format =null){
        if(isset($format)) return self::now()->endOfMonth()->format($format);
        return self::now()->endOfMonth();
    }

}
