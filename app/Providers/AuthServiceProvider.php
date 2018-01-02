<?php



namespace Genv\Otc\Providers;

use Genv\Otc\Auth\TokenGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Genv\Otc\Model' => 'Genv\Otc\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->app->auth->extend('token', function ($app) {
            return $app->make(TokenGuard::class);
        });
    }
}
