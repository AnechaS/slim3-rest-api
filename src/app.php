<?php

/**
 * Load dotenv
 * @see https://github.com/vlucas/phpdotenv
 */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(ROOT_DIR);
$dotenv->load();

if (getenv('APP_ENV') !== 'test') {
    $dotenv->required([
        'DB_CONNECTION',
        'DB_HOST',
        'DB_DATABASE',
        'DB_USERNAME',
        'DB_PASSWORD'
    ]);    
}

App\Helpers\Illuminate\Illuminate::init();

$container = require 'dependencies.php';
$app = new \Slim\App($container);
$app->add(new \App\Middlewares\TrailingSlash);

require 'routes.php';

return $app;