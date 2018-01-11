<?php



namespace Genv\Otc\Repository;

use Genv\Otc\Models\CommonConfig;
use Illuminate\Contracts\Cache\Repository as ContractsCacheRepository;

class WalletPingPlusPlus
{
    /**
     * Cache repository.
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Create the repository instance.
     *
     * @param \Illuminate\Contracts\Cache\Repository $cache
     */
    public function __construct(ContractsCacheRepository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get the Ping++ configuration.
     *
     * @return array
     */
    public function get(): array
    {
        if ($this->cache->has($this->cacheKey())) {
            return $this->cache->get($this->cacheKey());
        }

        $model = CommonConfig::firstOrCreate(
            ['name' => 'ping++', 'namespace' => 'wallet'],
            ['value' => '[]']
        );

        $this->cache->forever(
            $this->cacheKey(),
            $config = $this->resolveConfig(json_decode($model->value, true))
        );

        return $config;
    }

    /**
     * Save the Ping++ configuration.
     *
     * @param array $config
     * @return void
     */
    public function store(array $config)
    {
        CommonConfig::updateOrCreate(
            ['name' => 'ping++', 'namespace' => 'wallet'],
            ['value' => json_encode($config = $this->resolveConfig($config))]
        );

        $this->flush();
        $this->cache->forever($this->cacheKey(), $config);
    }

    /**
     * Get the config cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return 'wallet:pay-ping++';
    }

    /**
     * Flush all cache.
     *
     * @return void
     */
    public function flush()
    {
        $keys = [
            $this->cacheKey(),
        ];

        foreach ($keys as $key) {
            $this->cache->forget($key);
        }
    }

    /**
     * Resolve config.
     *
     * @param array $config
     * @return array
     */
    protected function resolveConfig(array $config = []): array
    {
        return array_merge([
            'app_id' => null,
            'secret_key' => null,
            'public_key' => null,
            'private_key' => null,
        ], $config);
    }
}
