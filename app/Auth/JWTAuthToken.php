<?php



namespace Genv\Otc\Auth;

use Tymon\JWTAuth\JWT;
use Illuminate\Support\Facades\Auth;
use Genv\Otc\Models\User as UserModel;
use Genv\Otc\Models\JWTCache as JWTCacheModel;

class JWTAuthToken
{
    protected $jwt;

    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    /**
     * Create user token.
     *
     * @param UserModel $user
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function create(UserModel $user)
    {
        return $this->token(
            $this->jwt->fromUser($user), $user
        );
    }

    /**
     * Refresh token.
     *
     * @param string $token
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function refresh(string $token)
    {
        $this->jwt->setToken($token);
        $user = $this->guard()->user();
        $token = $this->jwt->refresh();

        return $this->token($token, $user);
    }

    /**
     * Token save to database.
     *
     * @param string $token
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    protected function token(string $token, UserModel $user): string
    {
        if (! config('jwt.single_auth')) {
            return $token;
        }

        $this->jwt->setToken($token);
        JWTCacheModel::where('user_id', $user->id)->where('status', 0)->update([
            'status' => 1,
        ]);

        $payload = $this->jwt->getPayload();
        $cache = new JWTCacheModel();
        $cache->user_id = $user->id;
        $cache->key = $payload['jti'];
        $cache->value = ['valid_until' => time()];
        $cache->minutes = max(config('jwt.ttl'), config('jwt.refresh_ttl'));
        $cache->save();

        return $token;
    }
}
