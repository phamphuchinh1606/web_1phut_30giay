<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends BaseModel
{
    public const MENU_TYPE_ADMIN_CODE = 1;
    public const MENU_TYPE_ADMIN_NAME = "Admin";
    public const MENU_TYPE_EMPLOYEE_CODE = 2;
    public const MENU_TYPE_EMPLOYEE_NAME = "Employee";

    protected $primaryKey = 'menu_id';

    public $keyType = "string";
}
