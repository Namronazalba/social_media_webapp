<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\NotificationController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $pendingCount = 0;

            if (auth()->check()) {
                $pendingCount = NotificationController::getNotificationCounts();
            }

            $view->with('pendingCount', $pendingCount);
        });
    }
    protected $policies = [
        \App\Models\Post::class => \App\Policies\PostPolicy::class,
    ];
}
