<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Slim\Exception\NotFoundException;

/**
 * Dependencies
 * @see https://www.slimframework.com/docs/v3/tutorial/first-app.html#add-dependencies
 */

$container = new \Slim\Container(['settings' => config('settings')]);

$container['errorHandler'] = function ($c) {
    return function ($req, $res, $exception) use ($c) {
        // Object not fount
        if ($exception instanceof ModelNotFoundException) {
            return $res
                ->withStatus(404)
                ->withJson([
                    'message' => 'Object Not Found.'
                ]);
        }

        $response = [
            'message' => 'Internal Server Error.'
        ];

        if ($c->get('settings')['displayErrorDetails']) {
            $response['error'] = [
                'message' => $exception->getMessage(),
                'stack' => $exception->getTraceAsString()
            ];
        }
        return $res
            ->withStatus(500)
            ->withJson($response);
    };
};

$container["phpErrorHandler"] = function ($c) {
    return $c["errorHandler"];
};

$container['notFoundHandler'] = function ($c) {
    return function ($req, $res) use ($c) {
        return $res
            ->withStatus(404)
            ->withJson(['message' => 'Not Found.']);
    };
};

$container['trailingSlash'] = function ($c) {
    return new App\Middlewares\TrailingSlash;
};

$container['auth'] = function ($c) {
    return new App\Middlewares\Authorize;
};

return $container;