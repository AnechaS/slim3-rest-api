<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Slim\Exception\NotFoundException;

$container = $app->getContainer();

$container['errorHandler'] = function ($c) {
    return function ($req, $res, $exception) use ($c) {
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

$container['notAllowedHandler'] = function ($c) {
    return $c["notFoundHandler"];
};

$container['auth'] = function ($c) {
    return new App\Middlewares\Authorize;
};

return $container;