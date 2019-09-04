<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ScreenEnum extends Enum
{
    const SCREEN_TIME_KEEPING_URL =  "/time-keeping";
    const SCREEN_SALE_CART_SMALL_URL =  "/sale-cart-small";

    //Screen Admin
    const SCREEN_ADMIN_INPUT_DAILY_URL = "/admin/input-daily";
}
