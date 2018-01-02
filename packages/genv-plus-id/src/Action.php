<?php



namespace Genv\PlusID;

class Action
{
    protected $actions = [
        'auth/resolve' => \Genv\PlusID\Actions\Auth\Resolve::class,
        'auth/login' => \Genv\PlusID\Actions\Auth\Login::class,
        'user/check' => \Genv\PlusID\Actions\User\Check::class,
        'user/create' => \Genv\PlusID\Actions\User\Create::class,
        'user/delete' => \Genv\PlusID\Actions\User\Delete::class,
        'user/show' => \Genv\PlusID\Actions\User\Show::class,
        'user/update' => \Genv\PlusID\Actions\User\Update::class,
    ];

    public function action(string $action)
    {
        if (isset($this->actions[$action])) {
            return new $this->actions[$action];
        }

        abort(404, '不存在的 API.');
    }
}
