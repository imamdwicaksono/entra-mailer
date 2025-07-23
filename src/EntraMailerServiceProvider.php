use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use YourVendor\EntraMailer\EntraTransport;

class EntraMailerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/entra-mailer.php' => config_path('entra-mailer.php'),
        ], 'config');

        // Register custom mail transport
        Mail::extend('entra', function () {
            return new EntraTransport();
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/entra-mailer.php', 'entra-mailer');
    }
}
