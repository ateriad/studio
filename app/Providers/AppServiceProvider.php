<?php

namespace App\Providers;

use App\Services\SMS\Candoo;
use App\Services\SMS\SMS;
use Exception;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Sms::class, function () {
            switch (config('sms.driver')) {
                case 'candoo':
                    return new Candoo();
                default:
                    throw new Exception();
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Str::startsWith(config('app.url'), 'https')) {
            URL::forceScheme('https');
        }

        require(__DIR__ . '/../Services/Utils/helpers.php');
    }
}
