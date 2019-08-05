<?php

namespace App\Repositories\Eloquents;

use App\Models\Material;
use App\Models\Unit;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class MaterialRepository extends BaseRepository
{
    public function __construct(Material $model)
    {
        $this->model = $model;
    }

    public function selectAll()
    {
        $unitTableName = Unit::getTableName();
        $materialTableName = Material::getTableName();
        return $this->model::join($unitTableName,"$unitTableName.id","$materialTableName.unit_id")
            ->select("$materialTableName.*","$unitTableName.unit_name")->get();
    }

}
