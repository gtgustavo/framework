<?php

try {

    (new \Dotenv\Dotenv(__DIR__))->load();

} catch (\Dotenv\Exception\InvalidPathException $e) {

    //
}

return [
    'paths' => [
        'migrations' => '../../database/migrations',
        'seeds'      => '../../database/seeders'
    ],
    'migration_base_class' => '\App\Helpers\Migration\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => getenv('DB_CONNECTION'),
            'host'    => getenv('DB_HOST'),
            'name'    => getenv('DB_DATABASE'),
            'user'    => getenv('DB_USERNAME'),
            'pass'    => getenv('DB_PASSWORD'),
            'port'    => getenv('DB_PORT')
        ]
    ]
];