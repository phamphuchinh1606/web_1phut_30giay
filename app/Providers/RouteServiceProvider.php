<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $namespaceGuest = 'App\Http\Controllers\Guest';

    protected $namespaceAdmin = 'App\Http\Controllers\Admin';

    protected $namespaceEmployee = 'App\Http\Controllers\Employee';

    protected $prefixAdmin = 'admin';

    protected $prefixEmployee = '';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));

        //Router admin
        $this->routeAdmin();

        //Router Employee
        $this->routeEmployee();
    }

    private function routeAdmin(){
        //Router admin
        $middlewareAdmin = ['web','auth'];
//        $middlewareAdmin = ['web'];
        $listRoute = ['route_home','route_product','route_input_daily','route_time_keeping', 'route_payment_bill',
            'route_sale_report','route_check_in','route_setting','route_employee','route_sale_cart_small','route_finance',
            'route_role', 'route_user'];
        foreach ($listRoute as $routeName){
            Route::middleware($middlewareAdmin)
                ->namespace($this->namespaceAdmin)
                ->prefix($this->prefixAdmin)
                ->name($this->prefixAdmin.'.')
                ->group(base_path('routes/admin/'.$routeName.'.php'));
        }
    }

    private function routeEmployee(){
        //Router admin
        $middlewareAdmin = ['web','auth'];
//        $middlewareAdmin = ['web'];
        $listRoute = ['route_input_daily','route_time_keeping', 'route_payment_bill','route_sale_cart_small'];
        foreach ($listRoute as $routeName){
            Route::middleware($middlewareAdmin)
                ->namespace($this->namespaceEmployee)
                ->group(base_path('routes/employee/'.$routeName.'.php'));
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
