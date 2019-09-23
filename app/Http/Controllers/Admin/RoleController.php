<?php

namespace App\Http\Controllers\Admin;

use App\Common\PermissionRoleCommon;
use App\Repositories\Eloquents\PermissionRepository;
use App\Repositories\Eloquents\RolePermissionScreenRepository;
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Eloquents\ScreenRepository;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $roleRepository;
    protected $permissionRepository;
    protected $rolePermissionScreenRepository;
    protected $screenRepository;
    protected $roleService;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository, RolePermissionScreenRepository $rolePermissionScreenRepository,
                    ScreenRepository $screenRepository, RoleService $roleService)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->rolePermissionScreenRepository = $rolePermissionScreenRepository;
        $this->screenRepository = $screenRepository;
        $this->roleService = $roleService;
    }

    public function index(){
        $roles = $this->roleRepository->selectAll();
        return $this->viewAdmin('role.role',[
            'roles' => $roles
        ]);
    }

    public function showUpdate($id){
        $role = $this->roleRepository->find($id);
        $permissions = $this->permissionRepository->selectAll();
        $screenMap = $this->roleService->getScreenAll($role->id);
        $assignPermissions = PermissionRoleCommon::assignPermissionList();
        $rolePermissionScreens = $this->rolePermissionScreenRepository->getRolePermissionGroupScreen($id);
        return $this->viewAdmin('role.update_role',[
            'role' => $role,
            'permissions' => $permissions,
            'screenMap' => $screenMap,
            'assignPermissions' => $assignPermissions,
            'rolePermissionScreens' => $rolePermissionScreens
        ]);
    }

    public function update($id, Request $request){
        $values = $request->all();
        $values['id'] = $id;
        $this->roleService->update($values);
        return redirect()->route('admin.setting.role.update',['id' => $id])->with('message','Thêm chức năng màn hình thành công');
    }

    public function deleteRolePermission($id, $screenId){
        $this->rolePermissionScreenRepository->deleteLogic(array('role_id' => $id, 'screen_id' => $screenId));
        return redirect()->route('admin.setting.role.update',['id' => $id])->with('message','Thêm chức năng màn hình thành công');
    }
}
