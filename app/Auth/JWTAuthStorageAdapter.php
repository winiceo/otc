<?php



namespace Genv\Otc\Auth;

use Carbon\Carbon;
use Genv\Otc\Models\JWTCache;
use Tymon\JWTAuth\Contracts\Providers\Storage;

class JWTAuthStorageAdapter implements Storage
{
    /**
     * Add a new item into storage.
     *
     * @param string $key
     * @param string $value
     * @param int $minutes
     */
    public function add($key, $value, $minutes)
    {
        if (($res = $this->single('add', $key, $value, $minutes)) !== false) {
            return $res;
        }

        $token = JWTCache::find($key);
        if (! $token) {
            $token = new JWTCache();
            $token->user_id = 0;
            $token->key = $key;
            $token->value = $value;
        }

        $token->minutes = $minutes;
        $token->status = 1;
        $token->save();
    }

    /**
     * Add a new item into storage forever.
     *
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function forever($key, $value)
    {
        if (($res = $this->single('forever', $key, $value)) !== false) {
            return $res;
        }

        return $this->add($key, $value, 100000);
    }

    /**
     * Get an item from storage.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if (($res = $this->single('get', $key)) !== false) {
            return $res;
        }

        $cache = JWTCache::find($key);

        if (! $cache) {
            return null;
        }

        $now = Carbon::now();

        if ($cache->status && $now->diffInMinutes($cache->created_at) < $cache->minutes) {
            return $cache->value;
        } elseif ($now->diffInMinutes($cache->created_at) > $cache->minutes) {
            $cache->delete();
        }
    }

    /**
     * Remove an item from storage.
     *
     * @param string $key
     * @return bool
     */
    public function destroy($key)
    {
        if (($res = $this->single('destroy', $key)) !== false) {
            return $res;
        }

        return JWTCache::destroy($key);
    }

    /**
     * Remove all items associated.
     *
     * @return void
     */
    public function flush()
    {
        if (($res = $this->single('flush')) !== false) {
            return $res;
        }

        JWTCache::delete();
    }

    protected function single(string $method, ...$args)
    {
        if (config('jwt.single_auth')) {
            return false;
        }

        return $this->storage()->$method(...$args);
    }

    protected function storage()
    {
        return app(\Tymon\JWTAuth\Providers\Storage\Illuminate::class);
    }
}
