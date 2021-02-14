<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Slim\Exception\NotFoundException;

/**
 * Dependencies
 * @see https://www.slimframework.com/docs/v3/tutorial/first-app.html#add-dependencies
 */

$container = $app->getContainer();

$container['notFoundHandler'] = function ($container) {
    return function ($req, $res) use ($container) {
        return $res
            ->withStatus(404)
            ->withJson(['message' => 'Not Found.']);
    };
};

$container['errorHandler'] = function ($container) {
    return function ($req, $res, $exception) use ($container) {
        // Object not fount
        if ($exception instanceof ModelNotFoundException) {
            return $res
                ->withStatus(404)
                ->withJson([
                    'message' => 'Object Not Found.'
                ]);
        }

        print_r($exception);

        $response = [
            'message' => 'Internal Server Error.'
        ];

        if ($container->get('settings')['displayErrorDetails']) {
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