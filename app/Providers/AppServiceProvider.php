<?php

namespace App\Providers;

use App\Models\Checklist;
use App\Policies\ChecklistPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Checklist::class => ChecklistPolicy::class,
    ];

    public function register(): void {}

    public function boot(): void
    {
        // Use Tailwind-styled pagination views
        Paginator::useTailwind();

        // Register policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        // Share active emergency alert banner with all views
        // (demonstrates View::share)
        View::share('appName', config('app.name'));

        // Share pending tips count with all views for admin badge
        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->isAdmin()) {
                $view->with('pendingTipsCount',
                    \App\Models\Tip::where('is_approved', false)->count()
                );
            }
        });
    }
}
