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
     * Get Current Date
     * @return Carbon
     */
    public static function now()
    {
        return Carbon::now(static::timezone());
//        return new \DateTime('now', static::timezone());
    }

    public static function truncateTime(Carbon $date){
        if(isset($date)){
            $date->setHour(0);
            $date->setMinute(0);
            $date->setSecond(0);
            $date->setMicrosecond(0);
        }
        return $date;
    }

    public static function dateFromString($dateStr){
//        return new \DateTime($dateStr,static::timezone());
        return Carbon::parse($dateStr,self::timezone());
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

    public static function parseMonthToArrayDay($date, $addBeforeOnWeek = 0, $addAfterOnWeek = 0){
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
        $dayOfWeek = $firstDay->dayOfWeek;
        if($dayOfWeek == 0){
            $dayOfWeek = 7;
        }
        if($dayOfWeek + $addBeforeOnWeek - 7 > 1  && $addBeforeOnWeek > 0 && $addBeforeOnWeek < 7){
            for($dayNum = $dayOfWeek + $addBeforeOnWeek - 7 - 1 ; $dayNum >= 1 ; $dayNum--){
                $dayBefore = $firstDay->clone()->addDay(-1 * $dayNum);
                $dayOfWeekBefore = $dayBefore->dayOfWeek;
                $dayObject = new \StdClass();
                $dayObject->date_str = $dayBefore->format('Y-m-d');
                $dayObject->date = $dayBefore->clone();
                $dayObject->week_day = $weekMap[$dayOfWeekBefore];
                $dayObject->week_no = $dayOfWeekBefore;
                $dayObject->week_of_thing = $weekNo;
                $arrayDay[] = $dayObject;
            }
        }

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

        $dayOfWeek = $lastDay->dayOfWeek;
        if($dayOfWeek == 0){
            $dayOfWeek = 7;
        }
        if($dayOfWeek - $addAfterOnWeek < 0  && $addAfterOnWeek > 0 && $addAfterOnWeek < 7){
            for($dayNum = -1 ; $dayNum >= $dayOfWeek - $addAfterOnWeek ; $dayNum--){
                $dayBefore = $lastDay->clone()->addDay(-1 * $dayNum);
                $dayOfWeekBefore = $dayBefore->dayOfWeek;
                $dayObject = new \StdClass();
                $dayObject->date_str = $dayBefore->format('Y-m-d');
                $dayObject->date = $dayBefore->clone();
                $dayObject->week_day = $weekMap[$dayOfWeekBefore];
                $dayObject->week_no = $dayOfWeekBefore;
                $dayObject->week_of_thing = $weekNo;
                $arrayDay[] = $dayObject;
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

    public static function dateToWeekNo($date){
        return Carbon::parse($date,self::timezone())->dayOfWeek;
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

    public static function getArrayMonthByYearCurrent(){
        $date = self::now();
        $year = $date->year;
        $month = $date->month;
        $day = $date->day;
        $arrayMonth = [];
        for($i = 1; $i <= $month ; $i ++){
            $dateMonth = Carbon::createFromDate($year,$i,$day, self::timezone());
            $monthItem = new \StdClass();
            $monthItem->date = $dateMonth;
            $monthItem->month = $i;
            $monthItem->month_str = "Tháng $i";
            $monthItem->date_str = $dateMonth->format('Y/m');
            $arrayMonth[] = $monthItem;
        }
        return array_reverse($arrayMonth);
    }

}
