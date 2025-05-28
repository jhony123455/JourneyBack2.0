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
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
