<?php

namespace NwManager\Listeners;

use Illuminate\Contracts\Logging\Log;

class QueryLogListener
{
    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function handle($query, $bindings, $time, $name)
    {
        if (!config('app.debug')) {
            return;
        }

        $data = compact('bindings', 'time', 'name');

        // Format binding data for sql insertion
        foreach ($bindings as $i => $binding)
        {
            if ($binding instanceof \DateTime)
            {
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            }
            else if (is_string($binding))
            {
                $bindings[$i] = "'$binding'";
            }
        }

        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
        $query = vsprintf($query, $bindings);

        $this->log->info($query, $data);
    }
}