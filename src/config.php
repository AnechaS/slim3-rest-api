<?php

return [
    'settings' => [
        'addContentLengthHeader' => false,
        'displayErrorDetails' => filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN),
    ],

    'database' => [
        'driver' => getenv('DB_CONNECTION'),
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT') ?? 3306,
        'database' => getenv('DB_DATABASE'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
    ],

    'database_test' => [
        'driver' => 'sqlite',
        'database' => 'db-test.sqlite3',
    ]
];