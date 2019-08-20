<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquents\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index(){
        $branchId = 1;
        $employees = $this->employeeRepository->getEmployeeByBranch($branchId);
        return $this->viewAdmin('employee.index',[
            'branchId' => $branchId,
            'employees' => $employees
        ]);
    }

    public function showCreate(){
        $branchId = 1;
        return $this->viewAdmin('employee.create',[
            'branchId' => $branchId
        ]);
    }

    public function create(Request $request){
        $values = $request->all();
        $this->employeeRepository->create($values);
        return redirect()->route('admin.employee')->with('message','Cập Nhật Thành Công');
    }

    public function showUpdate($id){
        $employee = $this->employeeRepository->find($id);
        return $this->viewAdmin('employee.update',[
            'employee' => $employee
        ]);
    }

    public function update($id, Request $request){
        $values = $request->all();
        $values['id'] = $id;
        $this->employeeRepository->update($values);
        return redirect()->route('admin.employee')->with('message','Cập Nhật Thành Công');
    }

    public function delete($id){
        $this->employeeRepository->delete($id);
        return redirect()->route('admin.employee')->with('message','Xóa Thành Công');
    }
}
