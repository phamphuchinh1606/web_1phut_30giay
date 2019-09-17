<?php

namespace App\Repositories\Eloquents;

use App\Models\Branch;
use App\Models\OrderCheckOut;
use App\Models\PrepareMaterial;
use App\Models\Product;
use App\Models\Sale;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\DB;

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

    public function getProductPrepareMaterial($branchIds, $date){
        $tableProductName = Product::getTableName();
        $tablePrepareMaterialName = PrepareMaterial::getTableName();
        $tableCheckOutName = OrderCheckOut::getTableName();
        $tableBranchName = Branch::getTableName();

        $subQuery = Product::join("$tableBranchName",function($join) use ($tableBranchName){
            $join->on("$tableBranchName.id","$tableBranchName.id");
        })
            ->whereIn("$tableBranchName.id",$branchIds)
            ->select(
                    "$tableBranchName.id as branch_id",
                    "$tableBranchName.branch_name",
                    "$tableProductName.id as product_id",
                    "$tableProductName.product_name",
                    "$tableProductName.part_num",
                    "$tableProductName.product_the_same_id",
                    "$tableProductName.material_id"
                );

        $tableSubQueryName = "tableSub";

        $query = DB::table("$tablePrepareMaterialName")->rightJoinSub($subQuery,"$tableSubQueryName",function ($join) use ($tableSubQueryName, $tablePrepareMaterialName, $date){
            $join->on("$tableSubQueryName.branch_id","$tablePrepareMaterialName.branch_id")
                ->on("$tableSubQueryName.product_id","$tablePrepareMaterialName.product_id")
                ->where("$tablePrepareMaterialName.date_daily",$date);
        })->leftJoin("$tableCheckOutName",function($join)  use ($tableSubQueryName, $tableCheckOutName, $date){
            $join->on("$tableSubQueryName.branch_id","$tableCheckOutName.branch_id")
                ->on("$tableSubQueryName.material_id","$tableCheckOutName.material_id")
                ->where("$tableCheckOutName.check_out_date",$date);;
        })->select(
            "$tableSubQueryName.branch_id",
            "$tableSubQueryName.branch_name",
            "$tableSubQueryName.product_id",
            "$tableSubQueryName.product_name",
            "$tableSubQueryName.material_id",
            "$tablePrepareMaterialName.qty as qty_prepare",
            "$tablePrepareMaterialName.date_daily",
            "$tableCheckOutName.qty as qty_out",
            "$tableCheckOutName.check_out_date"
        );
        return $query->get();
    }

}
