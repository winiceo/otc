<?php



namespace Genv\PlusID\Actions\User;

use Genv\PlusID\Actions\Action;
use Genv\PlusID\Support\Message;
use Genv\Otc\Models\User as UserModel;

class Show extends Action
{
    public function getSignAction(): array
    {
        return [
            'app' => $this->client->id,
            'action' => 'user/show',
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
        $user = UserModel::find($this->request->user);
        $mode = in_array($mode = $this->mode(), ['json', 'jsonp']) ? $mode : 'json';

        return $this->response(new Message(200, 'success', ['user' => $user]), $mode);
    }
}
