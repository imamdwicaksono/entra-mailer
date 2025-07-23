<?php

namespace Mmsgilibrary\EntraMailer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use function config_path; // ← agar dikenali oleh Intelephense

class EntraMailerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/entra-mailer.php', 'entra-mailer');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/entra-mailer.php' => config_path('entra-mailer.php'),
        ], 'config');
    }
}
