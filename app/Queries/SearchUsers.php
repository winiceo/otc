<?php

namespace Genv\Otc\Queries;

use  Genv\Otc\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class SearchUsers
{
    /**
     * @return \ Genv\Otc\Models\User[]
     */
    public static function get(string $keyword, int $perPage = 20): Paginator
    {
        return User::where('name', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")
            ->orWhere('username', 'like', "%$keyword%")
            ->paginate($perPage)
            ->appends(['search' => $keyword]);
    }
}
