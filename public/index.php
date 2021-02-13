<?php

declare(strict_types=1);
define("ROOT_DIR", dirname(__DIR__));
chdir(ROOT_DIR);

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(ROOT_DIR);
$dotenv->load(true);
$dotenv->required(['DB_CONNECTION', 'DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD']);

require 'src/app.php';