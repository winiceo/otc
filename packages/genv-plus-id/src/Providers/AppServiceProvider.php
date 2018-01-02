<?php



namespace Genv\PlusID\Providers;

use Genv\Otc\Support\PackageHandler;
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
        $this->loadMigrationsFrom($this->app->make('path.plus-id.migrations'));

        // Register translations.
        $this->loadTranslationsFrom($this->app->make('path.plus-id.lang'), 'plus-id');

        // Register view namespace.
        $this->loadViewsFrom($this->app->make('path.plus-id.views'), 'plus-id');

        // Publish public resource.
        $this->publishes([
            $this->app->make('path.plus-id.assets') => $this->app->publicPath().'/assets/plus-id',
        ], 'plus-id-public');

        // Publish config.
        $this->publishes([
            $this->app->make('path.plus-id.config').'/plus-id.php' => $this->app->configPath('plus-id.php'),
        ], 'plus-id-config');
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
            $this->app->make('path.plus-id.config').'/plus-id.php',
            'plus-id'
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
            'path.plus-id' => $root = dirname(dirname(__DIR__)),
            'path.plus-id.assets' => $root.'/assets',
            'path.plus-id.config' => $root.'/config',
            'path.plus-id.database' => $database = $root.'/database',
            'path.plus-id.resources' => $resources = $root.'/resources',
            'path.plus-id.lang' => $resources.'/lang',
            'path.plus-id.views' => $resources.'/views',
            'path.plus-id.migrations' => $database.'/migrations',
            'path.plus-id.seeds' => $database.'/seeds',
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
        // Develop handler.
        $this->app->singleton('plus-id:dev-handler', function ($app) {
            return new \Genv\PlusID\Handlers\DevPackageHandler($app);
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
            'plus-id:dev-handler' => [
                \Genv\PlusID\Handlers\DevPackageHandler::class,
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
        $this->loadHandleFrom('plus-id-dev', 'plus-id:dev-handler');
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
