<?php

namespace Infrastructure\Providers;

use Domain\TokenValidator;
use Infrastructure\Http\Middleware\Token\BalancedBracketsTokenValidator;

use Domain\ShortUrlsService;
use Infrastructure\ShortUrlsTinyUrlService;

use Illuminate\Support\ServiceProvider;

class ShortUrlsServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $bindings = [
        TokenValidator::class => BalancedBracketsTokenValidator::class,
        ShortUrlsService::class => ShortUrlsTinyUrlService::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
