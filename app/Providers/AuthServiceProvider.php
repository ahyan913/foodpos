<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\Configuration::class => \App\Policies\ConfigurationPolicy::class,
        \App\Models\Store::class =>  \App\Policies\StorePolicy::class,
        \App\Models\Timeslot::class =>  \App\Policies\TimeslotPolicy::class,
        \App\Models\Menu::class =>  \App\Policies\MenuPolicy::class,
        \App\Models\ProductType::class =>  \App\Policies\TypePolicy::class,
        \App\Models\Product::class =>  \App\Policies\ProductPolicy::class,
        \App\Models\OptionGroup::class => \App\Policies\OptionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
