<?php

namespace App\Models;

class SettingOfDay extends BaseModel
{
    public const TYPE_OFF_WEEK = 1;
    public const TYPE_OFF_DAY = 2;

    protected $fillable = ['branch_id','type_day'];
}
