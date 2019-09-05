<?php
namespace App\Services;

use App\Common\Constant;
use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use Illuminate\Support\Facades\DB;

class EmployeeService extends BaseService {

    public function createEmployee($values){
        try{
            DB::beginTransaction();
            $employee = $this->employeeRepository->create($values);
            if(isset($values['selected_branch'])){
                $branchIds = $values['selected_branch'];
                if(isset($branchIds)){
                    foreach ($branchIds as $branchId){
                        $this->employeeBranchRepository->create(array('employee_id' => $employee->id, 'branch_id' => $branchId));
                    }
                }
            }
            if(isset($values['assign_employee'])) {
                $assignEmployee = $values['assign_employee'];
                if (isset($assignEmployee) && $assignEmployee == Constant::SWITCH_FLG_ON) {
                    $this->assignEmployeeSaleCartSmallRepository->create(array(
                        'employee_id' => $employee->id,
                        'branch_id' => $values['branch_id']
                    ));
                }
            }
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
    }

    public function updateEmployee($values){
        try{
            DB::beginTransaction();
            $employee = $this->employeeRepository->update($values);
            if(isset($employee)){
                $employee->deleteRelation();
                if(isset($values['selected_branch'])){
                    $branchIds = $values['selected_branch'];
                    if(isset($branchIds)){
                        foreach ($branchIds as $branchId){
                            $this->employeeBranchRepository->create(array('employee_id' => $employee->id, 'branch_id' => $branchId));
                        }
                    }
                }
                if(isset($values['assign_employee'])){
                    $assignEmployee = $values['assign_employee'];
                    if(isset($assignEmployee) && $assignEmployee == Constant::SWITCH_FLG_ON){
                        $this->assignEmployeeSaleCartSmallRepository->create(array('employee_id' => $employee->id, 'branch_id' => $values['branch_id']));
                    }
                }
            }

            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
    }

}
