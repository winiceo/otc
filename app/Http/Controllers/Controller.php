<?php



namespace Genv\Otc\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Genv\Otc\Traits\CreateJsonResponseData;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CreateJsonResponseData;
}
