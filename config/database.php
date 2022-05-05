<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    /*com'default' => env('DB_CONNECTION', 'mysql'),*/
    'default' => env('DB_CONNECTION', 'pgsql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'read' => [
                'host' => env('DB_HOST_READ', env('DB_HOST', '127.0.0.1')),
                'port' => env('DB_PORT_READ', env('DB_PORT', 3306)),
            ],
            'write' => [
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', 3306),
            ],
            'sticky' => true,
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PREFIX', ''),
            'strict' => env('DB_STRICT_MODE', true),
            'engine' => env('DB_ENGINE', null),
            'timezone' => env('DB_TIMEZONE', '-06:00'),
            'wait_timeout'  =>  '30',
            'interactive_timeout'   => '30',
            'net_read_timeout'  => '30',
            'options'   => array(
                PDO::ATTR_EMULATE_PREPARES => true,
            ),
            'modes'  => [
                'IGNORE_SPACE,',
                'STRICT_TRANS_TABLES',
                ],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST_T', '127.0.0.1'),
            'port' => env('DB_PORT_T', 5432),
            'database' => env('DB_DATABASE_T', 'forge'),
            'username' => env('DB_USERNAME_T', 'forge'),
            'password' => env('DB_PASSWORD_T', ''),
            'charset' => env('DB_CHARSET_T', 'utf8'),
            'prefix' => env('DB_PREFIX_T', ''),
            'schema' => env('DB_SCHEMA_T', 'public'),
            'sslmode' => env('DB_SSL_MODE_T', 'prefer'),
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

];
