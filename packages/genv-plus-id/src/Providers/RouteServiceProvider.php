<?php



namespace Genv\PlusID\Providers;

use Illuminate\Support\ServiceProvider;
use Genv\Otc\Support\ManageRepository;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(
            $this->app->make('path.plus-id').'/router.php'
        );
    }

    /**
     * Regoster the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Publish admin menu.
        $this->app->make(ManageRepository::class)->loadManageFrom('Plus ID', 'plus-id:admin-home', [
            'route' => true,
            'icon' => '🔌',
        ]);
    }
}
