<?php



namespace Genv\PlusID\Web\Controllers;

use Genv\PlusID\Server;
use Illuminate\Http\Request;
use Genv\PlusID\Models\Client as ClientModel;

class HomeController
{
    public function index(Request $request, Server $server, ClientModel $client)
    {
        $action = $request->action;

        return $server->setClient($client)
            ->dispatch($request, $action);
    }
}
