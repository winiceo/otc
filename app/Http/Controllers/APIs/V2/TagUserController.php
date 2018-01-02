<?php



namespace Genv\Otc\Http\Controllers\APIs\V2;

use Illuminate\Http\Request;
use Genv\Otc\Models\Tag as TagModel;
use Genv\Otc\Models\User as UserModel;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

class TagUserController extends Controller
{
    /**
     * Get all tags of the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function index(Request $request, ResponseFactoryContract $response)
    {
        return $this->userTgas($response, $request->user());
    }

    /**
     * Attach a tag for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Models\Tag $tag
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function store(Request $request, ResponseFactoryContract $response, TagModel $tag)
    {
        $user = $request->user();
        if ($user->tags()->newPivotStatementForId($tag->id)->first()) {
            return $response->json([
                'message' => [
                    trans('tag.user.attached', [
                        'tag' => $tag->name,
                    ]),
                ],
            ], 422);
        }

        $user->tags()->attach($tag);

        return $response->make('', 204);
    }

    /**
     * Detach a tag for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Models\Tag $tag
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function destroy(Request $request, ResponseFactoryContract $response, TagModel $tag)
    {
        $user = $request->user();

        if (! $user->tags()->newPivotStatementForId($tag->id)->first()) {
            return $response->json([
                'message' => [
                    trans('tag.user.destroyed', [
                        'tag' => $tag->name,
                    ]),
                ],
            ], 422);
        }

        $user->tags()->detach($tag);

        return $response->make('', 204);
    }

    /**
     * Get the user's tags.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response [description]
     * @param \Genv\Otc\Models\User $user [description]
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function userTgas(ResponseFactoryContract $response, UserModel $user)
    {
        return $response->json($user->tags, 200);
    }
}
