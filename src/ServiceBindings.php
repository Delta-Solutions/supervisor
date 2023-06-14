<?php

namespace DeltaSolutions\Supervisor;

trait ServiceBindings
{
    /**
     * All of the service bindings for Horizon.
     *
     * @var array
     */
    public $serviceBindings = [
        // General services...
        AutoScaler::class,
        Lock::class,
        Stopwatch::class,

        // Repository services...
        Contracts\SupervisorRepository::class => Repositories\DatabaseSupervisorRepository::class,
    ];
}
