<?php



namespace Genv\Otc\Http\Controllers\APIs\V2;

use Genv\Otc\Models\TagCategory as TagCategoryModel;
use Illuminate\Contracts\Routing\ResponseFactory as ResponseFactoryContract;

class TagController extends Controller
{
    /**
     * Get all tags.
     *
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @param \Genv\Otc\Models\TagCategory $categoryModel
     * @return mixed
     */
    public function index(ResponseFactoryContract $response, TagCategoryModel $categoryModel)
    {
        return $response->json(
            $categoryModel->with('tags')->orderBy('weight', 'desc')->get()
        )->setStatusCode(200);
    }
}
