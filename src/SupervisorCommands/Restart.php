<?php

namespace DeltaSolutions\Supervisor\SupervisorCommands;

use DeltaSolutions\Supervisor\Contracts\Restartable;

class Restart
{
    /**
     * Process the command.
     *
     * @param  \DeltaSolutions\Supervisor\Contracts\Restartable  $restartable
     * @return void
     */
    public function process(Restartable $restartable)
    {
        $restartable->restart();
    }
}
