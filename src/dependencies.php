<?php

/**
 * Dependencies
 * @see https://www.slimframework.com/docs/v3/tutorial/first-app.html#add-dependencies
 */

$container = $app->getContainer();

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $response->withJson(['message' => 'Not Found.'], 404);
    };
};

$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        $resp = [
            'message' => 'Internal Server Error.'
        ];

        if ($container->get('settings')['displayErrorDetails']) {
            $resp['error'] = [
                'message' => $exception->getMessage(),
                'stack' => $exception->getTraceAsString()
            ];
        }
        return $response->withJson($resp, 500);
    };
};