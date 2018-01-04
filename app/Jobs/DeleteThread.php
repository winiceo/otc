<?php

namespace Genv\Otc\Jobs;

use Genv\Otc\Modelss\Thread;

class DeleteThread
{
    /**
     * @var \Genv\Otc\Modelss\Thread
     */
    private $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function handle()
    {
        $this->thread->delete();
    }
}
