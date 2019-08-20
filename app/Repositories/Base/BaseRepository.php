<?php
namespace App\Repositories\Base;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /** @var BaseModel $model */
    protected $model;

    public function create($attribute)
    {
        $modelObject = new $this->model();
        foreach ($attribute as $key => $value){
            if(Schema::hasColumn($this->model::getTableName(),$key)){
                $modelObject[$key] = $value;
            }
        }
        return $modelObject->save();
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

    public function getByKey($whereKeys){
        $query = $this->model::whereRaw('1=1');
        foreach ($whereKeys as $key => $value){
            if(Schema::hasColumn($this->model::getTableName(),$key)){
                $query->where($key, $value);
            }
        }
        return $query->get();
    }

    public function findByKeyOrCreate($whereKeys){
        $query = $this->model::whereRaw('1=1');
        foreach ($whereKeys as $key => $value){
            if(Schema::hasColumn($this->model::getTableName(),$key)){
                $query->where($key, $value);
            }
        }
        $model = $query->first();
        if(!isset($model)){
            $model = $this->model->create($whereKeys);
        }
        return $model;
    }

    public function updateById($id, $input)
    {
        return $this->model->where('id', $id)
            ->update($input);
    }

    public function update($attribute){
        $keys = $this->model::getPrimaryKeyName();
        if(!is_array($keys)) $keys = [$keys];
        $query = $this->model::whereRaw('1=1');
        foreach ($keys as  $key){
            if(isset($attribute[$key])){
                $query->where($key, $attribute[$key]);
            }
        }
        $modelData = $query->first();
        if(isset($modelData)){
            foreach ($attribute as $key => $value){
                if(!array_search($key,$keys)){
                    if(Schema::hasColumn($this->model::getTableName(),$key)){
                        $modelData[$key] = $value;
                    }
                }
            }
            $modelData->save();
            return $modelData;
        }
        return null;
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
                if(is_array($value)){
                    $columnUpdate = '$values[$key]=';
                    foreach ($value as $columnValue){
                        if(Schema::hasColumn($this->model::getTableName(),$columnValue)){
                            if(!Str::endsWith($columnUpdate,'=')){
                                $columnUpdate = $columnUpdate . '+';
                            }
                            if(isset($values[$columnValue])){
                                $columnUpdate = $columnUpdate . '$values[\''.$columnValue.'\']';
                            }else{
                                $valueDB = 0;
                                eval('$valueDB = $modelData->'.$columnValue.';');
                                $columnUpdate = $columnUpdate . $valueDB;
                            }
                        }
                    }
                    eval($columnUpdate.';');
                    $modelData[$key] = $values[$key];
                }else  if(Schema::hasColumn($this->model::getTableName(),$key)){
                    $modelData[$key] = $value;
                }
            }
            $modelData->save();
            return $modelData;
        }else{
            $values = array_merge($values,$whereKeys);
            $valueInsertDbs = [];
            foreach ($values as $key => $value){
                if(Schema::hasColumn($this->model::getTableName(),$key)){
                    $valueInsertDbs[$key] = $values[$key];
                }
            }
            foreach ($valueInsertDbs as $key => $value){
                if(Schema::hasColumn($this->model::getTableName(),$key)){
                    if(is_array($value)){
                        $columnUpdate = '$valueInsertDbs[$key]=';
                        foreach ($value as $keyColumn => $columnValue){
                            if(Schema::hasColumn($this->model::getTableName(),$columnValue)){
                                if(!Str::endsWith($columnUpdate,'=')){
                                    $columnUpdate = $columnUpdate . '+';
                                }
                                if(isset($valueInsertDbs[$columnValue])){
                                    $columnUpdate = $columnUpdate . '$valueInsertDbs[\''.$columnValue.'\']';
                                }else{
                                    $columnUpdate = $columnUpdate . '0';
                                }
                            }
                        }
                        eval($columnUpdate.';');
                    }
                }
            }
            $this->model->insert($valueInsertDbs);
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

    public function delete($id){
        if(Schema::hasColumn($this->model::getTableName(),'id')){
            $itemModel = $this->model->find($id);
            if(isset($itemModel)){
                if(Schema::hasColumn($this->model::getTableName(),'delete_flg')){
                    $itemModel->delete_flg = 1;
                    $itemModel->save();
                }
            }
        }
    }

    public function deleteLogic($whereKeys){
        $keys = $this->model::getPrimaryKeyName();
        if(!is_array($keys)) $keys = [$keys];
        $query = $this->model->whereRaw('1=1');
        foreach ($keys as $key){
            if(isset($whereKeys[$key])){
                $query->where($key, $whereKeys[$key]);
            }
        }
        $listModel = $query->get();
        foreach ($listModel as $modelData){
            $modelData->delete();
        }
    }

}
