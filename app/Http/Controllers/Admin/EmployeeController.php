<?php

namespace App\Http\Controllers\Admin;

use App\Common\Constant;
use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\UserRoleRepository;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $employeeRepository;
    private $employeeService;
    private $userRoleRepository;

    public function __construct(EmployeeRepository $employeeRepository, EmployeeService $employeeService, UserRoleRepository $userRoleRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeService = $employeeService;
        $this->userRoleRepository = $userRoleRepository;
    }

    public function index(){
        $branchId = SessionHelper::getSelectedBranchId();
        $employees = $this->employeeRepository->getEmployeeAll();
        return $this->viewAdmin('employee.index',[
            'branchId' => $branchId,
            'employees' => $employees
        ]);
    }

    public function showCreate(){
        $branchId = SessionHelper::getSelectedBranchId();
        return $this->viewAdmin('employee.create',[
            'branchId' => $branchId
        ]);
    }

    public function create(Request $request){
        $values = $request->all();
        $this->employeeService->createEmployee($values);
        return redirect()->route('admin.employee')->with('message','Cập Nhật Thành Công');
    }

    public function showUpdate($id){
        $branchId = SessionHelper::getSelectedBranchId();
        $employee = $this->employeeRepository->find($id);
        if($employee->checkAssignSaleCartSmall($branchId)){
            $employee->is_check_assign = "checked='checked'";
        }
        return $this->viewAdmin('employee.update',[
            'employee' => $employee,
        ]);
    }

    public function update($id, Request $request){
        $values = $request->all();
        $values['id'] = $id;
        $values['branch_id'] = SessionHelper::getSelectedBranchId();
        $this->employeeService->updateEmployee($values);
        return redirect()->route('admin.employee')->with('message','Cập Nhật Thành Công');
    }

    public function addRoleEmployee($id, Request $request){
        $values = $request->all();
        $values['employee_id'] = $id;
        $this->userRoleRepository->create($values);
        $values['employee_id'] = $id;
    }

    public function delete($id){
        $this->employeeRepository->delete($id);
        return redirect()->route('admin.employee')->with('message','Xóa Thành Công');
    }
}
