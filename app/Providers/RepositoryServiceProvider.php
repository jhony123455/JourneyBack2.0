<?php

namespace App\Providers;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use App\Interfaces\DiaryEntryRepositoryInterface;
use App\Interfaces\DiaryEntryServiceInterface;
use App\Repositories\UserRepository;
use App\Repositories\DiaryEntryRepository;
use App\Services\UserService;
use App\Services\DiaryEntryService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(DiaryEntryRepositoryInterface::class, DiaryEntryRepository::class);
        $this->app->bind(DiaryEntryServiceInterface::class, DiaryEntryService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
