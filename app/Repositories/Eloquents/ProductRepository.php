<?php

namespace App\Repositories\Eloquents;

use App\Models\Product;
use App\Models\Sale;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function selectProductMergeSales($branchId,$date){
        $saleTableName = Sale::getTableName();
        $productTableName = Product::getTableName();
        return $this->model::leftjoin($saleTableName,function ($join) use ($saleTableName, $productTableName, $branchId, $date){
            $join->on("$saleTableName.product_id","$productTableName.id")
            ->where("$saleTableName.branch_id",$branchId)
            ->where("$saleTableName.sale_date",$date->format('Y-m-d'));
        })->select("$productTableName.*","$saleTableName.qty","$saleTableName.amount")->orderBy('id')->get();
    }

}
