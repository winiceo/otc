<?php



namespace Genv\PlusID\Actions\Auth;

use Genv\PlusID\Actions\Action;
use Genv\PlusID\Support\Message;
use Illuminate\Support\Facades\Auth;
use Genv\Otc\Models\User as UserModel;

class Login extends Action
{
    public function getSignAction(): array
    {
        return [
            'app' => $this->client->id,
            'action' => 'auth/login',
            'time' => (int) $this->request->time,
            'user' => (int) $this->request->user,
        ];
    }

    public function check()
    {
        if (($response = parent::check()) !== true) {
            return $response;
        } elseif (! UserModel::find($this->request->user)) {
            return $this->response(new Message(10003, 'fail'));
        }

        return true;
    }

    public function dispatch()
    {
        Auth::loginUsingId($this->request->user, true);

        return $this->response(new Message(200, 'success'));
    }
}
