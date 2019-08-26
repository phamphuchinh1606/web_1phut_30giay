<?php

namespace App\Http\Controllers\Admin;

use App\Common\Constant;
use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\EmployeeRoleRepository;
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Eloquents\UserRoleRepository;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $employeeRepository;
    private $employeeService;
    private $userRoleRepository;
    private $employeeRoleRepository;
    private $roleRepository;

    public function __construct(EmployeeRepository $employeeRepository, EmployeeService $employeeService, UserRoleRepository $userRoleRepository,
                        EmployeeRoleRepository $employeeRoleRepository, RoleRepository $roleRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeService = $employeeService;
        $this->userRoleRepository = $userRoleRepository;
        $this->employeeRoleRepository = $employeeRoleRepository;
        $this->roleRepository = $roleRepository;
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
        $roles = $this->roleRepository->getRoleUser();
        $employeeRoles = $this->employeeRoleRepository->getByKey(['employee_id' => $id]);
        if($employee->checkAssignSaleCartSmall($branchId)){
            $employee->is_check_assign = "checked='checked'";
        }
        return $this->viewAdmin('employee.update',[
            'employee' => $employee,
            'roles' => $roles,
            'employeeRoles' => $employeeRoles
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
        $this->employeeRoleRepository->create($values);
        return redirect()->route('admin.employee.update',['id' => $id])->with('message','Thêm Quyền Thành Công');
    }

    public function delete($id){
        $this->employeeRepository->delete($id);
        return redirect()->route('admin.employee')->with('message','Xóa Thành Công');
    }

    public function deleteRoleEmployee($id, $employeeRoleId){
        $this->employeeRoleRepository->deleteLogic(['id'=>$employeeRoleId]);
        return redirect()->route('admin.employee.update',['id' => $id])->with('message','Xóa Quyền Thành Công');
    }
}
