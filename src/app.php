<?php

require 'constants.php';
require 'utils.php';

/**
 * Load dotenv
 * @see https://github.com/vlucas/phpdotenv
 */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(ROOT_DIR);
$dotenv->load();
$dotenv->required([
    'DB_CONNECTION',
    'DB_HOST',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD'
]);

/**
 * Setup Eloquent
 * @see https://github.com/illuminate/database
 */
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection(config('database'));
$capsule->setEventDispatcher(
    new Illuminate\Events\Dispatcher(new Illuminate\Container\Container)
);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container = require 'dependencies.php';
$app = new \Slim\App($container);
$app->add('trailingSlash');

require 'routes.php';

$app->run();