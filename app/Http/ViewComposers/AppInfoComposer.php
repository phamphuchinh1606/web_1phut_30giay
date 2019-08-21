<?php

namespace App\Http\ViewComposers;

use App\Repositories\Eloquents\BranchRepository;
use App\Repositories\Eloquents\SettingRepository;
use Illuminate\View\View;

class AppInfoComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $settingService;

    protected $branchRepository;

    private static $appInfo;

    private static $branches;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(SettingRepository $settingService, BranchRepository $branchRepository)
    {
        // Dependencies automatically resolved by service container...
        $this->settingService = $settingService;
        $this->branchRepository = $branchRepository;
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
            self::$branches = $this->branchRepository->selectAll();
        }
        $view->with('appInfo', self::$appInfo)
            ->with('branches',self::$branches);
    }
}
