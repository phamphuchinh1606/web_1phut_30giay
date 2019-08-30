<?php

use App\Common\Constant;
use App\Common\RoleConstant;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermissionScreen;
use App\Models\Screen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function MicrosoftAzure\Storage\Samples\createContainerSample;

class RolePermisstionScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $screenAdmins = DB::table(Screen::getTableName())->where('screen_type', Screen::SCREEN_TYPE_ADMIN)->get();
        $screenEmployees = DB::table(Screen::getTableName())->where('screen_type', Screen::SCREEN_TYPE_EMPLOYEE)->get();
        $roleAdmins = DB::table(Role::getTableName())->where('role_type_id', RoleConstant::ROLE_TYPE_ADMIN_CODE)->get();
        $roleEmployees = DB::table(Role::getTableName())->where('role_type_id', RoleConstant::ROLE_TYPE_EMPLOYEE_CODE)->get();
        $permissions = DB::table(Permission::getTableName())->get();

        $mapRoleScreen = [
            //Quan Ly Cong ty
            2 => ['check_in','employee','employee.create','employee.update','finance','home','input','payment_bill','sale_cart_small','sale_report','setting','setting_of_day','time_keeping','user','user.create','user.update'],
            //Quan Ly Chi Nhanh
            3 => ['check_in','employee','employee.create','employee.update','finance','home','input','payment_bill','sale_cart_small','sale_report','setting','time_keeping'],
            //Quan Ly Nhan Vien
            4 => ['employee','employee.create','employee.update','time_keeping'],
            //Quan Ly Ban Hang
            5 => ['check_in','finance','home','input','payment_bill','sale_cart_small','sale_report'],
            //Quan Ly Chi Tieu
            6 => ['payment_bill'],

            //Employee
            //Nhan Vien Ban Hang
            7 => ['time_keeping_employee','sale_cart_small_employee'],
            //Quan Ly Ban Hang
            8 => ['input_employee','payment_bill_employee','time_keeping_employee','sale_cart_small_employee'],
            //Quan Ly Nhan Vien
            9 => ['time_keeping_employee','sale_cart_small_employee'],
        ];

        foreach ($roleAdmins as $role){
            $arrayScreenAssign = $mapRoleScreen[$role->id];
            if(isset($arrayScreenAssign) && count($arrayScreenAssign) > 0){
                foreach ($screenAdmins as $screen){
                    $kq = array_search($screen->screen_id, $arrayScreenAssign);
                    if($kq !== false){
                        foreach ($permissions as $permission){
                            switch ($role->id){
                                case 2:
                                    $assignCode = RoleConstant::ASSIGN_PERMISSION_ALL_ID;
                                    break;
                                case 7:
                                case 8:
                                case 9:
                                    $assignCode = RoleConstant::ASSIGN_PERMISSION_BRANCH_LOGIN_ID;
                                    break;
                                default:
                                    $assignCode = RoleConstant::ASSIGN_PERMISSION_BRANCH_ASSIGN_ID;
                            }
                            DB::table(RolePermissionScreen::getTableName())->insert([
                                'role_id' => $role->id,
                                'screen_id' => $screen->screen_id,
                                'permission_id' => $permission->id,
                                'assign_code' => $assignCode,
                            ]);
                        }
                    }

                }
            }
        }

        foreach ($roleEmployees as $role){
            $arrayScreenAssign = $mapRoleScreen[$role->id];
            if(isset($arrayScreenAssign) && count($arrayScreenAssign) > 0){
                foreach ($screenEmployees as $screen){
                    $kq = array_search($screen->screen_id, $arrayScreenAssign);
                    if($kq !== false){
                        foreach ($permissions as $permission){
                            switch ($role->id){
                                case 2:
                                    $assignCode = RoleConstant::ASSIGN_PERMISSION_ALL_ID;
                                    break;
                                case 7:
                                case 8:
                                case 9:
                                    $assignCode = RoleConstant::ASSIGN_PERMISSION_BRANCH_LOGIN_ID;
                                    break;
                                default:
                                    $assignCode = RoleConstant::ASSIGN_PERMISSION_BRANCH_ASSIGN_ID;
                            }
                            DB::table(RolePermissionScreen::getTableName())->insert([
                                'role_id' => $role->id,
                                'screen_id' => $screen->screen_id,
                                'permission_id' => $permission->id,
                                'assign_code' => $assignCode,
                            ]);
                        }
                    }

                }
            }
        }
    }
}
