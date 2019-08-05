<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getPrimaryKeyName()
    {
        return with(new static)->getKeyName();
    }

    public static function getFillableColumns()
    {
        return with(new static)->getFillable();
    }

    public function getFillable()
    {
        return $this->fillable;
    }
}
