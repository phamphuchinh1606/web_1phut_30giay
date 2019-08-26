<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\PaymentBill;
use App\Policies\MenuPolicy;
use App\Policies\PaymentBillPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Menu' => MenuPolicy::class,
        'App\Models\PaymentBill' => PaymentBillPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('payment_bill', 'App\Policies\PaymentBillPolicy');
        Gate::resource('menu', 'App\Policies\MenuPolicy');
    }
}
