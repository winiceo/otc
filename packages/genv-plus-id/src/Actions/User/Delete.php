<?php



namespace Genv\PlusID\Actions\User;

use Genv\PlusID\Actions\Action;
use Genv\PlusID\Support\Message;
use Genv\Otc\Models\User as UserModel;

class Delete extends Action
{
    public function getSignAction(): array
    {
        return [
            'app' => $this->client->id,
            'action' => 'user/delete',
            'time' => (int) $this->request->time,
            'user' => (int) $this->request->user,
        ];
    }

    public function dispatch()
    {
        UserModel::where('id', $this->request->user)->delete();

        return $this->response(new Message(200, 'success'));
    }
}
