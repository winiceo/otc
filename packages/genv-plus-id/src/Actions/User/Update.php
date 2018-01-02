<?php



namespace Genv\PlusID\Actions\User;

use Validator;
use Genv\PlusID\Actions\Action;
use Genv\PlusID\Support\Message;
use Genv\Otc\Models\User as UserModel;

class Update extends Action
{
    public function getSignAction(): array
    {
        return [
            'app' => $this->client->id,
            'action' => 'user/update',
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

        $validator = Validator::make($this->request->all(), [
            'name' => 'nullable|string|username|display_length:2,12|unique:users,name',
            'phone' => 'nullable|cn_phone|unique:users,phone',
            'email' => 'nullable|email|max:128|unique:users,email',
        ]);

        if (! $validator->fails()) {
            return true;
        }

        return $this->response(new Message(422, 'fail', $validator->errors()->toArray()));
    }

    public function dispatch()
    {
        $map = $this->request->only(['phone', 'name', 'email']);
        $user = UserModel::find($this->request->user);

        foreach ($map as $key => $value) {
            if ($value) {
                $user->$key = $value;
            }
        }

        $user->save();

        return $this->response(new Message(200, 'success'));
    }
}
