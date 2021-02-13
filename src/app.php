<?php
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

$config = require 'config.php';;

/**
 * Init Eloquent ORM
 * @see https://github.com/illuminate/database
 */
$capsule = new Capsule;
$capsule->addConnection($config['db']);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$app = new \Slim\App(['settings' => $config['settings']]);

// fix trailing slash
$app->add(function ($request, $response, $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        $uri = $uri->withPath(substr($path, 0, -1));

        if($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        }
        else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});

require 'dependencies.php';
require 'routes.php';

$app->run();