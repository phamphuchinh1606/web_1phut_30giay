<?php


namespace App\Repositories\Eloquents;

use App\Models\EmployeeBranch;
use App\Models\UserBranch;
use App\Repositories\Base\BaseRepository;
use App\Models\Branch;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class BranchRepository extends BaseRepository
{
    public function __construct(Branch $model)
    {
        $this->model = $model;
    }

    public function getListByEmployeeAssign($employeeId){
        $tableEmployeeBranchName = EmployeeBranch::getTableName();
        $tableBranchName = Branch::getTableName();
        return $this->model::join("$tableEmployeeBranchName","$tableEmployeeBranchName.branch_id","$tableBranchName.id")
            ->where("$tableEmployeeBranchName.employee_id", $employeeId)->select("$tableBranchName.*")->get();
    }

    public function getListByUserAssign($userId){
        $tableUserBranchName = UserBranch::getTableName();
        $tableBranchName = Branch::getTableName();
        return $this->model::join("$tableUserBranchName","$tableUserBranchName.branch_id","$tableBranchName.id")
            ->where("$tableUserBranchName.user_id", $userId)->select("$tableBranchName.*")->get();
    }
}
