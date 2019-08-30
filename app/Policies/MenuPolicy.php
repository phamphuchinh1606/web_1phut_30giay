<?php

namespace App\Policies;

use App\Common\PermissionRoleCommon;
use App\User;
use App\Models\Employee;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Cache;

class MenuPolicy
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
     * Determine whether the user can view any menus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny($user)
    {
    }

    /**
     * Determine whether the user can view the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function view($user, Menu $menu)
    {
//        return true;
        return PermissionRoleCommon::checkViewMenuRoleUser($user, $menu);
    }

    /**
     * Determine whether the user can create menus.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create($user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function update($user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can delete the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function delete($user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can restore the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function restore($user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the menu.
     *
     * @param  \App\User  $user
     * @param  \App\Menu  $menu
     * @return mixed
     */
    public function forceDelete($user, Menu $menu)
    {
        //
    }
}
