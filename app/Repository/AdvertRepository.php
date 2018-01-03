<?php

namespace Genv\Otc\Repository;


use Genv\Otc\Models\Advert;
use Genv\Otc\Scopes\StatusScope;

class AdvertRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Advert $advert)
    {
        $this->model = $advert;
    }


    public function page($number = 10, $sort = 'asc', $sortColumn = 'created_at')
    {
        $this->model = $this->checkAuthScope();

        return $this->model->orderBy($sortColumn, $sort)->with('User')->paginate($number);
    }

    /**
     * Get the ad record without draft scope.
     *
     * @param  int $id
     * @return mixed
     */
    public function getById($id)
    {
        $this->model = $this->checkAuthScope();

        return $this->model->with('User')->findOrFail($id);
    }

    /**
     * Store a new ad.
     * @param  array $data
     * @return Model
     */
    public function store($data)
    {
        $ad = $this->model->create($data);

        return $ad;
    }

    /**
     * Update a record by id.
     *
     * @param  int $id
     * @param  array $data
     * @return boolean
     */
    public function update(int $id, array $data)
    {
        $this->model = $this->checkAuthScope();

        $ad = $this->model->findOrFail($id);

        return $ad->update($data);
    }



    /**
     * Check the auth and the model without global scope when user is the admin.
     *
     * @return Model
     */
    public function checkAuthScope()
    {
        if (auth()->check() && auth()->user()->is_admin) {
            $this->model = $this->model->withoutGlobalScope(StatusScope::class);
        }

        return $this->model;
    }


    /**
     * Delete the draft article.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }
}
