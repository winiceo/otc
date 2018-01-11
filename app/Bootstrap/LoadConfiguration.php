<?php



namespace Genv\Otc\Bootstrap;

use Genv\Otc\Support\Configuration;
use Illuminate\Contracts\Foundation\Application;

class LoadConfiguration
{
    protected $app;
    protected $configuration;

    /**
     * Create the bootstrap instance.
     *
     */
    public function __construct(Application $app, Configuration $configuration)
    {
        $this->app = $app;
        $this->configuration = $configuration;
    }

    /**
     *  Run handler.
     *
     * @return void
     */
    public function handle()
    {
        static $loaded = false;
        if ($loaded) {
            return;
        }

        $this->app->config->set(
            $this->configuration->getConfigurationBase()
        );
    }
}
