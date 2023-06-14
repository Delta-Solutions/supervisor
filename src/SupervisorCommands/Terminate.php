<?php

namespace DeltaSolutions\Supervisor\SupervisorCommands;

use DeltaSolutions\Supervisor\Contracts\Terminable;

class Terminate
{
    /**
     * Process the command.
     *
     * @param  \DeltaSolutions\Supervisor\Contracts\Terminable  $terminable
     * @param  array  $options
     * @return void
     */
    public function process(Terminable $terminable, array $options)
    {
        $terminable->terminate($options['status'] ?? 0);
    }
}
