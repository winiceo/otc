<?php

namespace Genv\Web\Providers;

use Genv\Otc\Support\PackageHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Boorstrap the service provider.
     *
     * @return void
     */
    public function boot()
    {
        // Register a database migration path.
        $this->loadMigrationsFrom($this->app->make('path.web.migrations'));

        // Register translations.
        $this->loadTranslationsFrom($this->app->make('path.web.lang'), 'web');

        // Register view namespace.
        $this->loadViewsFrom($this->app->make('path.web.views'), 'web');

        // Publish public resource.
        $this->publishes([
            $this->app->make('path.web.assets') => $this->app->publicPath().'/assets/web',
        ], 'web-public');

        // Publish config.
        $this->publishes([
            $this->app->make('path.web.config').'/web.php' => $this->app->configPath('web.php'),
        ], 'web-config');



        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->isAdmin();
        });

        Blade::if('profile', function ($user) {
            return Auth::check() && Auth::user()->id == $user->id;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bind all of the package paths in the container.
        $this->bindPathsInContainer();

        // Merge config.
        $this->mergeConfigFrom(
            $this->app->make('path.web.config').'/web.php',
            'web'
        );

        // register cntainer aliases
        $this->registerCoreContainerAliases();

        // Register singletons.
        $this->registerSingletions();

        // Register Plus package handlers.
        $this->registerPackageHandlers();
    }

    /**
     * Bind paths in container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        foreach ([
            'path.web' => $root = dirname(dirname(__DIR__)),
            'path.web.assets' => $root.'/assets',
            'path.web.config' => $root.'/config',
            'path.web.database' => $database = $root.'/database',
            'path.web.resources' => $resources = $root.'/resources',
            'path.web.lang' => $resources.'/lang',
            'path.web.views' => $resources.'/views',
            'path.web.migrations' => $database.'/migrations',
            'path.web.seeds' => $database.'/seeds',
        ] as $abstract => $instance) {
            $this->app->instance($abstract, $instance);
        }
    }

    /**
     * Register singletons.
     *
     * @return void
     */
    protected function registerSingletions()
    {
        // Owner handler.
        $this->app->singleton('web:handler', function () {
            return new \Genv\Web\Handlers\PackageHandler();
        });

        // Develop handler.
        $this->app->singleton('web:dev-handler', function ($app) {
            return new \Genv\Web\Handlers\DevPackageHandler($app);
        });
    }

    /**
     * Register the package class aliases in the container.
     *
     * @return void
     */
    protected function registerCoreContainerAliases()
    {
        foreach ([
            'web:handler' => [
                \Genv\Web\Handlers\PackageHandler::class,
            ],
            'web:dev-handler' => [
                \Genv\Web\Handlers\DevPackageHandler::class,
            ],
        ] as $abstract => $aliases) {
            foreach ($aliases as $alias) {
                $this->app->alias($abstract, $alias);
            }
        }
    }

    /**
     * Register Plus package handlers.
     *
     * @return void
     */
    protected function registerPackageHandlers()
    {
        $this->loadHandleFrom('web', 'web:handler');
        $this->loadHandleFrom('web-dev', 'web:dev-handler');
    }

    /**
     * Register handler.
     *
     * @param string $name
     * @param \Genv\Otc\Support\PackageHandler|string $handler
     * @return void
     */
    private function loadHandleFrom(string $name, $handler)
    {
        PackageHandler::loadHandleFrom($name, $handler);
    }
}
