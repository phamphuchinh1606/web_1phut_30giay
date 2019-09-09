<?php

namespace App\Models;

class OrderCheckIn extends BaseModel
{
    public const CHECK_IN_TYPE = 1;
    public const MOVE_IN_TYPE = 2;

    public const CHECK_IN_TYPE_CHARGE = 11;
    public const CHECK_IN_TYPE_CHARGE_NAME = 'Tính phí';
    public const CHECK_INT_TYPE_NOT_CHARGE = 12;
    public const CHECK_IN_TYPE_NOT_CHARGE_NAME = 'Không tính phí';

    public static function arrayTypeCheckInCharge(){
        return array(
            self::CHECK_IN_TYPE_CHARGE,
            self::CHECK_INT_TYPE_NOT_CHARGE
        );
    }

    public static function arrayTypeCheckInMoneyCharge(){
        return array(
            self::CHECK_IN_TYPE,
            self::CHECK_IN_TYPE_CHARGE
        );
    }
}
