<?php

namespace Tejuino\Admingyms;

use Illuminate\Support\ServiceProvider;
use Tejuino\Adminbase\AdminbaseServiceProvider;
use Tejuino\Adminbase\Package;

class AdmingymsServiceProvider extends AdminbaseServiceProvider
{
    protected $config;

    public function boot()
    {
        $this->config = Package::getConfig(__DIR__);
        $this->publishFiles(__DIR__);
    }

}
