<?php

namespace Mmsgilibrary\EntraMailer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use function config_path; // ← agar dikenali oleh Intelephense
use Mmsgilibrary\EntraMailer\EntraTransport;

class EntraMailerServiceProvider extends ServiceProvider
{
    public function boot()
{
    // Publikasi config
    $this->publishes([
        __DIR__ . '/Config/entra-mailer.php' => config_path('entra-mailer.php'),
    ], 'config');

    // Registrasi transport
    Mail::extend('entra', function (array $config = []) {
        return new EntraTransport();
    });
}
}
