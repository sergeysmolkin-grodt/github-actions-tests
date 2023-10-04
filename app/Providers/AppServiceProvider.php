<?php

namespace App\Providers;

use App\Interfaces\AppointmentRepositoryInterface;
use App\Interfaces\AutoScheduleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Subscription;
use App\Repositories\AppointmentRepository;
use App\Repositories\AutoScheduleRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Services\ZoomService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\SubscriptionRepositoryInterface;
use App\Repositories\SubscriptionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ZoomService::class, function ($app) {
            return new ZoomService();
        });

        $this->app->bind(AutoScheduleRepositoryInterface::class, AutoScheduleRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(env('APP_ENV') === 'local') {
            URL::forceRootUrl(env('APP_URL'));
            URL::forceScheme('https');
        }
        Model::preventSilentlyDiscardingAttributes();
    }
}
