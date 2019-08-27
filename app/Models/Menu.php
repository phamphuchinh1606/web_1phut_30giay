<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends BaseModel
{
    protected $primaryKey = 'menu_id';

    public $keyType = "string";
}
