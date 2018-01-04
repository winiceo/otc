<?php

namespace Genv\Otc\Jobs;

use Genv\Otc\Modelss\Thread;

class UnmarkThreadSolution
{
    /**
     * @var \ Genv\Otc\Models\User
     */
    private $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function handle()
    {
        $this->thread->unmarkSolution();
    }
}
