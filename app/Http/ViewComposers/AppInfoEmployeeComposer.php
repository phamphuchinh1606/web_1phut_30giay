<?php

namespace App\Http\ViewComposers;

use App\Common\AuthCommon;
use App\Common\Constant;
use App\Common\PermissionRoleCommon;
use App\Common\RoleConstant;
use App\Repositories\Eloquents\BranchRepository;
use App\Repositories\Eloquents\MenuRepository;
use App\Repositories\Eloquents\SettingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppInfoEmployeeComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $settingService;

    protected $branchRepository;

    protected $menuRepository;

    private static $appInfo;

    private static $branches;

    private static $menus;



    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(SettingRepository $settingService, BranchRepository $branchRepository, MenuRepository $menuRepository)
    {
        // Dependencies automatically resolved by service container...
        $this->settingService = $settingService;
        $this->branchRepository = $branchRepository;
        $this->menuRepository = $menuRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if(!isset(self::$appInfo)){
            self::$appInfo = $this->settingService->firstOrNew(['id' => 1]);
        }
        if(!isset(self::$branches)){
            if(AuthCommon::AuthEmployee()->check()){
                $user = AuthCommon::AuthEmployee()->user();
                if(PermissionRoleCommon::checkRoleRoot($user)){
                    self::$branches = $this->branchRepository->selectAll();
                }else{
                    self::$branches = $this->branchRepository->getListByEmployeeAssign($user->id);
                }
            }else{
                self::$branches = [];
            }
        }
        if(!isset(self::$menus)){
            $user = AuthCommon::AuthEmployee()->user();
            $menuType = RoleConstant::MENU_TYPE_EMPLOYEE_CODE;
            self::$menus = $this->menuRepository->selectAll($menuType, $user);
        }
        $view->with('appInfo', self::$appInfo)
            ->with('branches',self::$branches)
            ->with('menus', self::$menus);
    }
}
