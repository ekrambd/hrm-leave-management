<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Repositories\DesignationRepository;
use App\Repositories\Interfaces\DesignationRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\LeaveRepository;
use App\Repositories\Interfaces\LeaveRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            DesignationRepositoryInterface::class,
            DesignationRepository::class
        );
        
        $this->app->bind(
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        );

        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );

        $this->app->bind(
            LeaveRepositoryInterface::class,
            LeaveRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   

        Gate::define('manage-departments', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('manage-employees', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('manage-leave-requests', function ($user) {
            return in_array($user->role_id, [1]);
        });


        Gate::define('manage-designations', function ($user) {
            return in_array($user->role_id, [1]);
        });


        Gate::define('manage-employees', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('employee-leaves', function ($user) {
            return $user->role_id == 2;
        });

        Gate::define('admin', function ($user) {
            return $user->role_id === 1;
        });

        Gate::define('employee', function ($user) {
            return $user->role_id === 2;
        });

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
    }
}
