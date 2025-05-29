<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\TagRepositoryInterface;
use App\Repositories\TagRepository;
use App\Interfaces\ActivityRepositoryInterface;
use App\Repositories\ActivityRepository;
use App\Interfaces\CalendarEventRepositoryInterface;
use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\CalendarEventRepository;
use App\Interfaces\DiaryEntryServiceInterface;
use App\Services\DiaryEntryService;
use App\Interfaces\UserServiceInterface;
use App\Services\UserService;
use App\Services\ImageService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CalendarEventRepositoryInterface::class, CalendarEventRepository::class);
        $this->app->bind(DiaryEntryServiceInterface::class, DiaryEntryService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->singleton(ImageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
