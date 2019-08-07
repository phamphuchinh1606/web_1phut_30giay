<?php

namespace App\Repositories\Eloquents;

use App\Models\Sale;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SaleRepository extends BaseRepository
{
    public function __construct(Sale $model)
    {
        $this->model = $model;
    }

    public function sumAmountSale($branchId,$date){
        return $this->model::where('branch_id',$branchId)->where('sale_date',$date)->sum('amount');
    }

}
