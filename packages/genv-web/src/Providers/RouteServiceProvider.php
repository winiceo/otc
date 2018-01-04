<?php

namespace Genv\Web\Providers;

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
            $this->app->make('path.web').'/router.php'
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
        $this->app->make(ManageRepository::class)->loadManageFrom('web', 'web:admin-home', [
            'route' => true,
            'icon' => '📦',
        ]);
    }
}
