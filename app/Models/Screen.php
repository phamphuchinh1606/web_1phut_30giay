<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends BaseModel
{
    public const SCREEN_TYPE_ADMIN = 1;
    public const SCREEN_TYPE_EMPLOYEE = 2;

    protected $primaryKey = 'screen_id';

    protected $keyType = 'string';
}
