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

    public function selectProductMergeSales($date){
        $saleTableName = Sale::getTableName();
        $productTableName = Product::getTableName();
        return $this->model::leftjoin($saleTableName,function ($join) use ($saleTableName, $productTableName, $date){
            $join->on("$saleTableName.product_id","$productTableName.id")
            ->where("$saleTableName.sale_date",$date->format('Y-m-d'));
        })->select("$productTableName.*","$saleTableName.qty","$saleTableName.amount")->get();
    }

}
