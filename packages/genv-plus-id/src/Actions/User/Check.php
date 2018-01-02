<?php



namespace Genv\PlusID\Actions\User;

use Genv\PlusID\Actions\Action;
use Genv\PlusID\Support\Message;
use Genv\Otc\Models\User as UserModel;

class Check extends Action
{
    public function getSignAction(): array
    {
        return [
            'app' => $this->client->id,
            'action' => 'user/check',
            'time' => (int) $this->request->time,
        ];
    }

    public function dispatch()
    {
        $map = $this->request->only(['phone', 'name', 'email']);
        $map['id'] = $this->request->user;
        foreach ($map as $key => &$value) {
            if (! $value) {
                $value = null;
                continue;
            }

            $value = (bool) UserModel::where($key, $value)->first();
        }

        return $this->response(new Message(200, 'success', $map));
    }
}
