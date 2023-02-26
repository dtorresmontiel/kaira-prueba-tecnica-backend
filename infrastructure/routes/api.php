<?php

use Illuminate\Support\Facades\Route;

use Infrastructure\Http\Controllers\ShortUrlsController;
use Infrastructure\Http\Middleware\Token\TokenIsValid;

Route::post('/v1/short-urls', ShortUrlsController::class)->middleware(TokenIsValid::class);

