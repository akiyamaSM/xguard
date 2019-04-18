<?php

namespace xguard\Providers;

use Carbon\Carbon;
use xguard\Repositories\Activity\ActivityRepository;
use xguard\Repositories\Activity\EloquentActivity;
use xguard\Repositories\Country\CountryRepository;
use xguard\Repositories\Country\EloquentCountry;
use xguard\Repositories\Permission\EloquentPermission;
use xguard\Repositories\Permission\PermissionRepository;
use xguard\Repositories\Role\EloquentRole;
use xguard\Repositories\Role\RoleRepository;
use xguard\Repositories\Session\DbSession;
use xguard\Repositories\Session\SessionRepository;
use xguard\Repositories\User\EloquentUser;
use xguard\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        config(['app.name' => settings('app_name')]);
        \Illuminate\Database\Schema\Builder::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, EloquentUser::class);
        $this->app->singleton(ActivityRepository::class, EloquentActivity::class);
        $this->app->singleton(RoleRepository::class, EloquentRole::class);
        $this->app->singleton(PermissionRepository::class, EloquentPermission::class);
        $this->app->singleton(SessionRepository::class, DbSession::class);
        $this->app->singleton(CountryRepository::class, EloquentCountry::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
