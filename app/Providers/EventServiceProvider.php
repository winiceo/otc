<?php



namespace Genv\Otc\Providers;

use Illuminate\Support\Facades\Event;
use Genv\Otc\Support\BootstrapAPIsEventer;
use Illuminate\Contracts\Events\Dispatcher as EventsDispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Illuminate\Notifications\Events\NotificationSent::class => [
            \Genv\Otc\Listeners\VerificationCode::class,
        ],
    ];

    /**
     * Register the provider service.
     *
     * @return void
     */
    public function register()
    {
        // Run parent register method.
        parent::register();

        // Register BootstrapAPIsEventer event singleton.
        $this->app->singleton(BootstrapAPIsEventer::class, function ($app) {
            return new BootstrapAPIsEventer(
                $app->make(EventsDispatcherContract::class)
            );
        });
    }
}
