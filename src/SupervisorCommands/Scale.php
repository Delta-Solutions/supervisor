<?php

namespace DeltaSolutions\Supervisor\SupervisorCommands;

use DeltaSolutions\Supervisor\Supervisor;

class Scale
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
        $supervisor->scale($options['scale']);
    }
}
