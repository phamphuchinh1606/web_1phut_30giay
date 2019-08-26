<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\EmployeeRoleRepository;
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\UserRoleRepository;
use App\Services\EmployeeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    private $userRepository;
    private $userRoleRepository;
    private $roleRepository;

    public function __construct( UserService $userService,UserRepository $userRepository, UserRoleRepository $userRoleRepository, RoleRepository $roleRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index(){
        $users = $this->userRepository->selectAll();
        return $this->viewAdmin('user.index',[
            'users' => $users
        ]);
    }

    public function showCreate(){
        return $this->viewAdmin('user.create');
    }

    public function create(Request $request){
        $values = $request->all();
        $this->userService->createUser($values);
        return redirect()->route('admin.user')->with('message','Tạo Mới Thành Công');
    }

    public function showUpdate($id){
        $user = $this->userRepository->find($id);
        $roles = $this->roleRepository->getRoleAdmin();
        $userRoles = $this->userRoleRepository->getByKey(['user_id' => $id]);
        return $this->viewAdmin('user.update',[
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }
//
//    public function update($id, Request $request){
//        $values = $request->all();
//        $values['id'] = $id;
//        $values['branch_id'] = SessionHelper::getSelectedBranchId();
//        $this->employeeService->updateEmployee($values);
//        return redirect()->route('admin.employee')->with('message','Cập Nhật Thành Công');
//    }
//
//    public function addRoleEmployee($id, Request $request){
//        $values = $request->all();
//        $values['employee_id'] = $id;
//        $this->employeeRoleRepository->create($values);
//        return redirect()->route('admin.employee.update',['id' => $id])->with('message','Thêm Quyền Thành Công');
//    }
//
    public function delete($id){
        $this->userRepository->delete($id);
        return redirect()->route('admin.user')->with('message','Xóa Thành Công');
    }
//
//    public function deleteRoleEmployee($id, $employeeRoleId){
//        $this->employeeRoleRepository->deleteLogic(['id'=>$employeeRoleId]);
//        return redirect()->route('admin.employee.update',['id' => $id])->with('message','Xóa Quyền Thành Công');
//    }
}
