<?php

namespace Genv\Otc\Jobs;

use Genv\Otc\Modelss\Reply;
use Genv\Otc\Modelss\Thread;

class MarkThreadSolution
{
    /**
     * @var \Genv\Otc\Modelss\Thread
     */
    private $thread;

    /**
     * @var \Genv\Otc\Modelss\Reply
     */
    private $solution;

    public function __construct(Thread $thread, Reply $solution)
    {
        $this->thread = $thread;
        $this->solution = $solution;
    }

    public function handle()
    {
        $this->thread->markSolution($this->solution);
    }
}
