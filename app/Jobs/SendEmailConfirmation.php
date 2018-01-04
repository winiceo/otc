<?php

namespace Genv\Otc\Jobs;

use Genv\Otc\Models\User;
use App\Mail\EmailConfirmation;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;

class SendEmailConfirmation
{
    use SerializesModels;

    /**
     * @var \Genv\Otc\Models\User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;



    }

    public function handle(Mailer $mailer)
    {
        $mailer->to($this->user->emailAddress())
            ->send(new EmailConfirmation($this->user));
    }
}
