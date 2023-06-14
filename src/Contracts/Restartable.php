<?php

namespace DeltaSolutions\Supervisor\Contracts;

interface Restartable
{
    /**
     * Restart the process.
     *
     * @return void
     */
    public function restart();
}
