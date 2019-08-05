<?php
namespace App\Services;

class MaterialService extends BaseService {

    public function loadDataFormInput(){
        $materialTypes = $this->materialTypeRepository->selectAll();
        $materials = $this->materialRepository->selectAll();
        dd($materials);
    }

}