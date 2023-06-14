<?php

namespace DeltaSolutions\Supervisor\SupervisorCommands;

use DeltaSolutions\Supervisor\Supervisor;

class Balance
{
    /**
     * Process the command.
     *
     * @param  \DeltaSolutions\Supervisor\Supervisor  $supervisor
     * @param  array  $options
     * @return void
     */
    public function process(Supervisor $supervisor, array $options)
    {
        $supervisor->balance($options);
    }
}
