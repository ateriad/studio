<?php

namespace App\Providers;

use App\Services\Otp\Otp;
use App\Services\Otp\Redis as OtpRedis;
use App\Services\SMS\Candoo;
use App\Services\SMS\SMS;
use App\Services\Token\Jwt as TokenJwt;
use App\Services\Token\Token;
use Exception;
use Illuminate\Support\Facades\App;
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

        $this->app->singleton(Token::class, function () {
            switch (config('token.type')) {
                case 'jwt':
                    return new TokenJwt();
                default:
                    throw new Exception();
            }
        });

        $this->app->singleton(Otp::class, function () {
            switch (config('otp.driver')) {
                case 'redis':
                    return new OtpRedis();
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
        if (App::environment('production')) {
            URL::forceRootUrl(config('app.url'));
        }

        if (Str::startsWith(config('app.url'), 'https')) {
            URL::forceScheme('https');
        }

        require(__DIR__ . '/../Services/Utils/helpers.php');
    }
}
