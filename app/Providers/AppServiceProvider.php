<?php



namespace Genv\Otc\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use function Genv\Otc\validateUsername;
use Genv\Otc\Packages\Wallet\TypeManager;
use function Genv\Otc\validateChinaPhoneNumber;
use Genv\Otc\Packages\Wallet\TargetTypeManager;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // 注册验证规则.
        $this->registerValidator();

    }

    /**
     * Resgister the application service.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cdn', function ($app) {
            return new \Genv\Otc\Cdn\UrlManager($app);
        });

        $this->app->singleton(TypeManager::class, function ($app) {
            return new TypeManager($app);
        });

        $this->app->singleton(TargetTypeManager::class, function ($app) {
            return new TargetTypeManager($app);
        });

        $this->registerMorpMap();

        $this->addAcceptableJsonType();

    }
    /**
     * Add "application/json" to the "Accept" header for the current request.
     */
    protected function addAcceptableJsonType()
    {
        $this->app->rebinding('request', function ($app, $request) {
            if ($request->is('api/*')) {
                $accept = $request->header('Accept');

                if (! str_contains($accept, ['/json', '+json'])) {
                    $accept = rtrim('application/json,'.$accept, ',');

                    $request->headers->set('Accept', $accept);
                    $request->server->set('HTTP_ACCEPT', $accept);
                    $_SERVER['HTTP_ACCEPT'] = $accept;
                }
            }
        });
    }
    /**
     * 注册验证规则.
     *
     * @return void
     */
    protected function registerValidator()
    {
        // 注册中国大陆手机号码验证规则
        $this->app->validator->extend('cn_phone', function (...$parameters) {
            return validateChinaPhoneNumber($parameters[1]);
        });

        // 注册用户名验证规则
        $this->app->validator->extend('username', function (...$parameters) {
            return validateUsername($parameters[1]);
        });

        // 注册显示长度验证规则
        $this->app->validator->extend('display_length', function ($attribute, string $value, array $parameters) {
            unset($attribute);

            return $this->validateDisplayLength($value, $parameters);
        });
    }

    /**
     * 验证显示长度计算.
     *
     * @param strint|int $value
     * @param array $parameters
     * @return bool
     */
    protected function validateDisplayLength(string $value, array $parameters): bool
    {
        if (empty($parameters)) {
            throw new \InvalidArgumentException('Parameters must be passed');
            // 补充 min 位.
        } elseif (count($parameters) === 1) {
            $parameters = [0, array_first($parameters)];
        }

        list($min, $max) = $parameters;

        preg_match_all('/[a-zA-Z0-9_]/', $value, $single);
        $length = count($single[0]) / 2 + mb_strlen(preg_replace('([a-zA-Z0-9_])', '', $value));

        return $length >= $min && $length <= $max;
    }

    /**
     * Register model morp map.
     *
     * @return void
     */
    protected function registerMorpMap()
    {
        $this->setMorphMap([
            'users' => \Genv\Otc\Models\User::class,
            'comments' => \Genv\Otc\Models\Comment::class,
        ]);
    }

    /**
     * Set the morph map for polymorphic relations.
     *
     * @param array|null $map
     * @param bool|bool $merge
     * @return array
     */
    private function setMorphMap(array $map = null, bool $merge = true)
    {
        Relation::morphMap($map, $merge);
    }
}
