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

    public static function dateFromString($dateStr){
        return new \DateTime($dateStr,static::timezone());
    }

    public static function dateFormat($value, $format = "d-m-Y H:i"){
        return Carbon::parse($value,self::timezone())->format($format);
    }

    public static function addDay($value, $day, $format = "d-m-Y H:i"){
        return Carbon::parse($value,self::timezone())->addDay($day)->format($format);
    }

    public static function startOfMonth($date = null, $format = null){
        if(!isset($date)) $date = self::now();
        if(isset($format)){
            return  Carbon::parse($date,self::timezone())->startOfMonth()->format($format);
        }
        return Carbon::parse($date,self::timezone())->startOfMonth();
    }

    public static function endOfMonth($date = null, $format =null){
        if(!isset($date)) $date = self::now();
        if(isset($format)) return Carbon::parse($date,self::timezone())->endOfMonth()->format($format);
        return Carbon::parse($date,self::timezone())->endOfMonth();
    }

    public static function parseMonthToArrayDay($date){
        $firstDay = Carbon::parse($date,self::timezone())->startOfMonth();
        $lastDay = Carbon::parse($date,self::timezone())->endOfMonth();
        $nextDay = $firstDay->clone();
        $arrayDay = [];
        $weekMap = [
            0 => 'Chủ Nhật',
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
        ];
        $weekNo = 1;
        while($nextDay->format('Y-m-d') <= $lastDay->format('Y-m-d')){
            $dayOfWeek = $nextDay->dayOfWeek;
            $dayObject = new \StdClass();
            $dayObject->date_str = $nextDay->format('Y-m-d');
            $dayObject->date = $nextDay->clone();
            $dayObject->week_day = $weekMap[$dayOfWeek];
            $dayObject->week_no = $dayOfWeek;
            $dayObject->week_of_thing = $weekNo;
            $arrayDay[] = $dayObject;
            $nextDay = $nextDay->addDay(1);
            if($dayOfWeek == 0){
                $weekNo++;
            }
        }
        return $arrayDay;
    }

    public static function getArrayDateByCurrentDate($date, $firstDayNum = -4, $lastDayNum = 4){
        $firstDay = Carbon::parse($date,self::timezone())->addDay($firstDayNum);
        $lastDay = Carbon::parse($date,self::timezone())->addDay($lastDayNum);
        $nextDay = $firstDay->clone();
        $arrayDay = [];
        $weekMap = [
            0 => 'Chủ Nhật',
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
        ];
        while($nextDay->format('Y-m-d') <= $lastDay->format('Y-m-d')){
            $dayOfWeek = $nextDay->dayOfWeek;
            $dayObject = new \StdClass();
            $dayObject->date_str = $nextDay->format('Y-m-d');
            $dayObject->date = $nextDay->clone();
            $dayObject->week_day = $weekMap[$dayOfWeek];
            $dayObject->week_no = $dayOfWeek;
            $arrayDay[] = $dayObject;
            $nextDay = $nextDay->addDay(1);
        }
        return $arrayDay;
    }

    public static function dateToWeek($date){
        $weekMap = [
            0 => 'Chủ Nhật',
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
        ];
        if(isset($date)){
            return $weekMap[Carbon::parse($date,self::timezone())->dayOfWeek];
        }
        return null;
    }

    public static function parseWeekToArray($date){
        $firstDay = Carbon::parse($date,self::timezone())->startOfMonth();
        $lastDay = Carbon::parse($date,self::timezone())->endOfMonth();
        $nextDay = $firstDay->clone();
        $arrayWeek = [];
        $weekObject = new \StdClass();
        $weekNo = 1;
        while($nextDay->format('Y-m-d') <= $lastDay->format('Y-m-d')){
            $dayOfWeek = $nextDay->dayOfWeek;
            if($dayOfWeek == 1 || $nextDay->format('Y-m-d') == $firstDay->format('Y-m-d')){
                $weekObject = new \StdClass();
                $weekObject->start_date = $nextDay->clone();
                $weekObject->start_date_str = $weekObject->start_date->format('Y-m-d');
                $weekObject->week_of_thing = $weekNo;
                $weekObject->date_array = [];
                $weekNo++;
            }
            if($dayOfWeek == 0 || $nextDay->format('Y-m-d') == $lastDay->format('Y-m-d')){
                $weekObject->end_date = $nextDay->clone();
                $weekObject->end_date_str = $weekObject->end_date->format('Y-m-d');
                $arrayWeek[] = $weekObject;
            }
            $weekObject->date_array[] = $nextDay->clone();
            $nextDay = $nextDay->addDay(1);
        }
        return $arrayWeek;
    }

    public static function getWeekArray(){
        $weekMap = [
            0 => 'Chủ Nhật',
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
        ];
        return $weekMap;
    }

}
