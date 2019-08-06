<?php
namespace App\Repositories\Base;

use App\Models\Base\BaseModel;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories\Base
 */
interface BaseRepositoryInterface
{
    /**
     * @param $input
     * @return BaseModel
     */
    public function create($input);

    /**
     * @param $id
     * @param $input
     * @return BaseModel
     */
    public function updateById($id, $input);

    /**
     * @param $values
     * @param $whereKeys
     * @return mixed
     */
    public function updateOrCreate($values, $whereKeys);

    /**
     * @param $id
     * @param $relations
     * @return BaseModel
     */
    public function find($id, $relations);

    /**
     * @param $input
     * @return BaseModel
     */
    public function firstOrNew($input);

    /**
     * @param $input
     * @return BaseModel
     */
    public function firstOrCreate($input);

    /**
     * @param $input
     * @return mixed
     */
    public function insertMulti($input);

    public function selectAll();
}
