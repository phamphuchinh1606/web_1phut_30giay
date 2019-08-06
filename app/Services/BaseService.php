<?php
namespace App\Services;

use App\Models\OrderCancel;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\OrderCancelRepository;
use App\Repositories\Eloquents\OrderCheckInRepository;
use App\Repositories\Eloquents\OrderCheckOutRepository;
use App\Repositories\Eloquents\StockDailyRepository;
use App\Repositories\Eloquents\UnitRepository;

class BaseService {

    protected $materialRepository;
    protected $materialTypeRepository;
    protected $unitRepository;
    protected $orderCheckInRepository;
    protected $orderCheckOutRepository;
    protected $orderCancelRepository;
    protected $stockDailyRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, UnitRepository $unitRepository,
                OrderCheckInRepository $orderCheckInRepository, OrderCheckOutRepository $orderCheckOutRepository, OrderCancelRepository $orderCancelRepository,
                StockDailyRepository $stockDailyRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->materialTypeRepository = $materialTypeRepository;
        $this->unitRepository = $unitRepository;
        $this->orderCheckInRepository = $orderCheckInRepository;
        $this->orderCheckOutRepository = $orderCheckOutRepository;
        $this->orderCancelRepository = $orderCancelRepository;
        $this->stockDailyRepository = $stockDailyRepository;
    }


}
