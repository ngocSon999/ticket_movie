<?php

namespace App\Providers;

use App\Http\Repositories\CategoryRepoInterface;
use App\Http\Repositories\Impl\CategoryRepository;
use App\Http\Repositories\Impl\UserRepository;
use App\Http\Repositories\UserRepoInterface;
use App\Http\Services\CategoryServiceInterface;
use App\Http\Services\Impl\CategoryService;
use App\Http\Services\Impl\SentinelService;
use App\Http\Services\SentinelServiceInterface;
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
        app()->bind(CategoryServiceInterface::class, CategoryService::class);
        app()->bind(SentinelServiceInterface::class, SentinelService::class);
        app()->bind(CategoryRepoInterface::class, CategoryRepository::class);
        app()->bind(UserRepoInterface::class, UserRepository::class);
    }
}
