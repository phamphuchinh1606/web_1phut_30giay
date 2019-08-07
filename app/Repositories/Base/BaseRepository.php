<?php
namespace App\Repositories\Base;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Schema;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /** @var BaseModel $model */
    protected $model;

    public function create($attribute)
    {
        return $this->model->create($attribute);
    }

    public function find($id, $relations = [])
    {
        if (!empty($relations)) {
            return $this->model->with($relations)->find($id);
        }

        return $this->model->find($id);
    }

    public function findByKey($whereKeys){
        $query = $this->model::whereRaw('1=1');
        foreach ($whereKeys as $key => $value){
            if(Schema::hasColumn($this->model::getTableName(),$key)){
                $query->where($key, $value);
            }
        }
        return $query->first();
    }

    public function updateById($id, $input)
    {
        return $this->model->where('id', $id)
            ->update($input);
    }

    public function updateOrCreate($values, $whereKeys)
    {
        $query = $this->model::whereRaw('1=1');
        foreach ($whereKeys as $key => $value){
            if(Schema::hasColumn($this->model::getTableName(),$key)){
                $query->where($key, $value);
            }
        }
        $modelData = $query->first();
        if(isset($modelData)){
            foreach ($values as $key => $value){
                $modelData[$key] = $value;
            }
            $modelData->save();
        }else{
            $values = array_merge($values,$whereKeys);
            $this->model->insert($values);
        }
    }

    public function selectAll()
    {
        return $this->model::orderBy($this->model::getPrimaryKeyName())->get();
    }

    public function firstOrNew($input)
    {
        return $this->model->firstOrNew($input);
    }

    public function firstOrCreate($input)
    {
        return $this->model->firstOrCreate($input);
    }

    public function insertMulti($input)
    {
        return $this->model->insert($input);
    }

    public function updateModel($model){
        if(isset($model)){
            $model->save();
        }
    }

}
