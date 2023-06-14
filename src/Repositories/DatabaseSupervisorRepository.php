<?php

namespace DeltaSolutions\Supervisor\Repositories;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Redis\Factory as RedisFactory;
use Illuminate\Support\Arr;
use DeltaSolutions\Supervisor\Contracts\SupervisorRepository;
use DeltaSolutions\Supervisor\Supervisor;
use Illuminate\Support\Facades\DB;

class DatabaseSupervisorRepository implements SupervisorRepository
{

    /**
     * Get the names of all the supervisors currently running.
     *
     * @return array
     */
    public function names()
    {
        return ['default'];
    }

    /**
     * Get information on all of the supervisors.
     *
     * @return array
     */
    public function all()
    {
        return $this->get([]);
    }

    /**
     * Get information on a supervisor by name.
     *
     * @param  string  $name
     * @return \stdClass|null
     */
    public function find($name)
    {
        return Arr::get($this->get([$name]), 0);
    }

    /**
     * Get information on the given supervisors.
     *
     * @param  array  $names
     * @return array
     */
    public function get(array $names)
    {
        $records = DB::table('supervisors');
        if (filled($names)) {
            $records = $records->whereIn('name', $names);
        }

        $records = $records->get();

        return collect($records)->filter()->map(function ($record) {

            $record = array_values((array) $record);

            return !$record[0] ? null : (object) [
                'name'      => $record[1],
                'master'    => $record[2],
                'pid'       => $record[3],
                'status'    => $record[4],
                'processes' => json_decode($record[5], true),
                'options'   => json_decode($record[6], true),
            ];
        })->filter()->all();
    }

    /**
     * Get the longest active timeout setting for a supervisor.
     *
     * @return int
     */
    public function longestActiveTimeout()
    {
        return collect($this->all())->max(function ($supervisor) {
            return $supervisor->options['timeout'];
        }) ?: 0;
    }

    /**
     * Update the information about the given supervisor process.
     *
     * @param  \DeltaSolutions\Supervisor\Supervisor  $supervisor
     * @return void
     */
    public function update(Supervisor $supervisor)
    {
        $processes = $supervisor->processPools->mapWithKeys(function ($pool) use ($supervisor) {
            return [$supervisor->options->connection.':'.$pool->queue() => count($pool->processes())];
        })->toJson();

        Db::table('supervisors')->updateOrInsert(['name' => $supervisor->name], [
                'name'      => $supervisor->name,
                'master'    => implode(':', explode(':', $supervisor->name, -1)),
                'pid'       => $supervisor->pid(),
                'status'    => $supervisor->working ? 'running' : 'paused',
                'processes' => $processes,
                'options'   => $supervisor->options->toJson()
            ]
        );

    }

    /**
     * Remove the supervisor information from storage.
     *
     * @param  array|string  $names
     * @return void
     */
    public function forget($names)
    {
        $names = (array) $names;

        if (empty($names)) {
            return;
        }

        $this->connection()->del(...collect($names)->map(function ($name) {
            return 'supervisor:'.$name;
        })->all());

        $this->connection()->zrem('supervisors', ...$names);
    }

    /**
     * Remove expired supervisors from storage.
     *
     * @return void
     */
    public function flushExpired()
    {
        $this->connection()->zremrangebyscore('supervisors', '-inf',
            CarbonImmutable::now()->subSeconds(14)->getTimestamp()
        );
    }

}
