<?php
namespace App\Helpers;
use App\Common\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionHelper{
    public const KEY_SELECTED_BRANCH_ID = "selected_branch_id";
    public const KEY_SELECTED_BRANCH_NAME = "selected_branch_name";
    public const KEY_SELECTED_MONTH = "selected_month";

    public static function setSelectedBranchId($branchId){
        Session::put(self::KEY_SELECTED_BRANCH_ID, $branchId);
    }

    public static function setSelectedBranchName($branchName){
        Session::put(self::KEY_SELECTED_BRANCH_NAME, $branchName);
    }

    public static function setSelectedMonth($date){
        Session::put(self::KEY_SELECTED_MONTH, $date);
    }

    public static function getSelectedBranchId(){
        return Session::get(self::KEY_SELECTED_BRANCH_ID);
    }

    public static function getSelectedBranchName(){
        return Session::get(self::KEY_SELECTED_BRANCH_NAME);
    }

    public static function getSelectedMonth(){
        return Session::get(self::KEY_SELECTED_MONTH);
    }

}
