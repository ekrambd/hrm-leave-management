<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Repositories\DesignationRepository;
use App\Repositories\Interfaces\DesignationRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
    }
}
