<?php

namespace DeltaSolutions\Supervisor;

class SupervisorFactory
{
    /**
     * Create a new supervisor instance.
     *
     * @param  \DeltaSolutions\Supervisor\SupervisorOptions  $options
     * @return \DeltaSolutions\Supervisor\Supervisor
     */
    public function make(SupervisorOptions $options)
    {
        return new Supervisor($options);
    }
}
