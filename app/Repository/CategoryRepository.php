<?php

namespace Genv\Otc\Repository;

use App\Category;

class CategoryRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * Get record by the name.
     * 
     * @param  string $name
     * @return collection
     */
    public function getByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
}
