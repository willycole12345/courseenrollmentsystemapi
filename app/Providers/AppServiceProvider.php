<?php

namespace App\Providers;

use App\Models\Course;
use App\Policies\CoursePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
    Course::class => CoursePolicy::class,
];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function ($request) {
         return Limit::perMinute(6)->by(optional($request->user())->id ?: $request->ip());
       });
    }
}
