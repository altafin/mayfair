<?php

namespace App\Providers;

use App\Repositories\Contracts\PersonSimplifiedRepositoryInterface;
use App\Repositories\Contracts\RegionRepositoryInterface;
use App\Repositories\Contracts\StateRepositoryInterface;
use App\Repositories\Contracts\CityRepositoryInterface;

use App\Repositories\PersonSimplifiedRepository;
use App\Repositories\RegionRepository;
use App\Repositories\StateRepository;
use App\Repositories\CityRepository;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        $this->app->bind(PersonSimplifiedRepositoryInterface::class, PersonSimplifiedRepository::class);
        $this->app->bind(RegionRepositoryInterface::class, RegionRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
    }
}
