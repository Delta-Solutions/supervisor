<?php

namespace DeltaSolutions\Supervisor\SupervisorCommands;

use DeltaSolutions\Supervisor\Contracts\Pausable;

class ContinueWorking
{
    /**
     * Process the command.
     *
     * @param  \DeltaSolutions\Supervisor\Contracts\Pausable  $pausable
     * @return void
     */
    public function process(Pausable $pausable)
    {
        $pausable->continue();
    }
}
