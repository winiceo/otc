<?php



namespace Genv\Otc\Repository;

use Genv\Otc\Models\CommonConfig;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class WalletRatio
{
    use Macroable;

    /**
     * Cache repository.
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Create the cash type respositorie.
     *
     */
    public function __construct(CacheRepository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get the ratio.
     *
     * @return int
     */
    public function get(): int
    {
        if ($this->cache->has($this->cacheKey())) {
            return $this->cache->get($this->cacheKey());
        }

        $model = CommonConfig::firstOrCreate(
            ['name' => 'wallet:ratio', 'namespace' => 'common'],
            ['value' => 100]
        );

        $this->cache->forever($this->cacheKey(), $ratio = intval($model->value));

        return $ratio;
    }

    /**
     * Save or update settings.
     *
     * @param int $ratio
     * @return void
     */
    public function store(int $ratio)
    {
        CommonConfig::updateOrCreate(
            ['name' => 'wallet:ratio', 'namespace' => 'common'],
            ['value' => $ratio]
        );

        $this->flush();
        $this->cache->forever($this->cacheKey(), $ratio);
    }

    /**
     * Get the config cache key.
     *
     * @return string
     */
    public function cacheKey(): string
    {
        return 'wallet:cash-ratio';
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
            'bootstrappers',
        ];

        foreach ($keys as $key) {
            $this->cache->forget($key);
        }
    }
}
