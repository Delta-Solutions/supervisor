<?php

namespace DeltaSolutions\Supervisor;

trait EventMap
{
    /**
     * All of the Horizon event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        Events\SupervisorProcessRestarting::class => [
            //
        ],


    ];
}
