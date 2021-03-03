<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Dotenv\Dotenv;

class BaseTestCase extends TestCase {
    public function runApp($requestMethod, $requestUri, $requestData = null, $authToken = null) {
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        $request = Request::createFromEnvironment($environment);
        if ($authToken) {
            $request = $request->withHeader('Authorization', 'Bearer: ' . $authToken);
        }

        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        $response = new Response();

        $app = require ROOT_DIR . '/src/app.php';

        return $app->process($request, $response);
    }
}