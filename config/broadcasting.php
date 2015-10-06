<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    */

    'default' => env('BROADCAST_DRIVER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'socketcluster' => [
          'driver' => 'socketcluster',
          'secure' => env('BROADCAST_SOCKETCLUSTER_SECURE', false),
          'host'   => env('BROADCAST_SOCKETCLUSTER_HOST', '127.0.0.1'),
          'port'   => env('BROADCAST_SOCKETCLUSTER_PORT', '3000'),
          'path'   => env('BROADCAST_SOCKETCLUSTER_PATH', '/socketcluster/'),
        ],

        'fanout' => [
            'driver' => 'fanout',
            'realm_id' => env('BROADCAST_FANOUT_REALM_ID', ''),
            'realm_key' => env('BROADCAST_FANOUT_REALM_KEY', ''),
            'ssl' => true,
            'publish_async' => false
        ],

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('BROADCAST_PUSHER_KEY'),
            'secret' => env('BROADCAST_PUSHER_SECRET'),
            'app_id' => env('BROADCAST_PUSHER_APP_ID'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

    ],

];
