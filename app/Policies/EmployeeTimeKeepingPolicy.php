<?php

namespace App\Policies;

use App\Common\PermissionRoleCommon;
use App\Enums\ScreenEnum;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\EmployeeTimeKeeping;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeTimeKeepingPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if (PermissionRoleCommon::checkRoleRoot($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any employee time keepings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(Authenticatable $user)
    {
        //
    }

    /**
     * Determine whether the user can view the employee time keeping.
     *
     * @param  \App\User  $user
     * @param  \Models\EmployeeTimeKeeping  $employeeTimeKeeping
     * @return mixed
     */
    public function view(Authenticatable $user, EmployeeTimeKeeping $employeeTimeKeeping)
    {
        //
    }

    /**
     * Determine whether the user can create employee time keepings.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(Authenticatable $user)
    {

    }

    /**
     * Determine whether the user can update the employee time keeping.
     *
     * @param  \App\User  $user
     * @param  \Models\EmployeeTimeKeeping  $employeeTimeKeeping
     * @return mixed
     */
    public function update(Authenticatable $user, EmployeeTimeKeeping $employeeTimeKeeping = null)
    {
        return PermissionRoleCommon::checkScreenUpdateRoleUser($user, ScreenEnum::SCREEN_TIME_KEEPING_URL);
    }

    /**
     * Determine whether the user can delete the employee time keeping.
     *
     * @param  \App\User  $user
     * @param  \Models\EmployeeTimeKeeping  $employeeTimeKeeping
     * @return mixed
     */
    public function delete(Authenticatable $user, EmployeeTimeKeeping $employeeTimeKeeping)
    {
        //
    }

    /**
     * Determine whether the user can restore the employee time keeping.
     *
     * @param  \App\User  $user
     * @param  \Models\EmployeeTimeKeeping  $employeeTimeKeeping
     * @return mixed
     */
    public function restore(Authenticatable $user, EmployeeTimeKeeping $employeeTimeKeeping)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the employee time keeping.
     *
     * @param  \App\User  $user
     * @param  \Models\EmployeeTimeKeeping  $employeeTimeKeeping
     * @return mixed
     */
    public function forceDelete(Authenticatable $user, EmployeeTimeKeeping $employeeTimeKeeping)
    {
        //
    }
}
