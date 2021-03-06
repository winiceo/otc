<?php



namespace Genv\Otc\Http\Controllers\APIs\V2;

use Illuminate\Http\Request;
use Genv\Otc\Models\User as UserModel;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

class UserFollowController extends Controller
{
    /**
     * List followers of a user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Models\User $user
     * @return mixed
     */
    public function followers(Request $request, ResponseFactoryContract $response, UserModel $user)
    {
        $target = $request->user('api')->id ?? 0;
        $limit = $request->query('limit', 15);
        $offset = $request->query('offset', 0);

        $followers = $user->followers()
            ->offset($offset)
            ->limit($limit)
            ->get();

        return $user->getConnection()->transaction(function () use ($followers, $target, $response) {
            return $response->json($followers->map(function (UserModel $user) use ($target) {
                $user->following = $user->hasFollwing($target);
                $user->follower = $user->hasFollower($target);

                return $user;
            }))->setStatusCode(200);
        });
    }

    /**
     * List users followed by another user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Models\User $user
     * @return mixed
     */
    public function followings(Request $request, ResponseFactoryContract $response, UserModel $user)
    {
        $target = $request->user('api')->id ?? 0;
        $limit = $request->query('limit', 15);
        $offset = $request->query('offset', 0);

        $followings = $user->followings()
            ->offset($offset)
            ->limit($limit)
            ->get();

        return $user->getConnection()->transaction(function () use ($followings, $target, $response) {
            return $response->json($followings->map(function (UserModel $user) use ($target) {
                $user->following = $user->hasFollwing($target);
                $user->follower = $user->hasFollower($target);

                return $user;
            }))->setStatusCode(200);
        });
    }
}
