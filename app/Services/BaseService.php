<?php
namespace App\Services;

use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\UnitRepository;

class BaseService {

    protected $materialRepository;
    protected $materialTypeRepository;
    protected $unitRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, UnitRepository $unitRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->materialTypeRepository = $materialTypeRepository;
        $this->unitRepository = $unitRepository;
    }


}