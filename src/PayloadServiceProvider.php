<?php

namespace PerfectOblivion\Payload;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PayloadServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->bootResponseMacros();
    }

    /**
     * Boot the Response macros.
     */
    public function bootResponseMacros()
    {
        Response::mixin(new \PerfectOblivion\Payload\Macros\Response);
    }
}
