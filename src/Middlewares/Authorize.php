<?php

namespace App\Middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\JWT\ExpiredException;
use App\Models\User;
use Exception;

class Authorize {

    public function __invoke($req, $res, $next) {
        $response = [
            'message' => 'Unauthorized'
        ];
        
        $token = $req->getHeaderLine('authorization');

        if (!$token) {
            return $res->withJson($response, 401);
        }

        try {
            $token = preg_replace('/^bearer:(\s+)?/i', '', $token);
            $tokenDecoded = JWT::decode($token, getenv("SECRET_KEY"), array('HS256'));     
        } catch (Exception $e) {
            if ($e instanceof ExpiredException) {
                return $res->withJson(['message' => 'Token expired'], 401);
            }

            return $res->withJson($response, 401);
        }

        $user = User::find($tokenDecoded->id);
        if (!$user) {
            return $res->withJson($response, 401);
        }

        $req = $req->withAttribute('user', $user);

        return $next($req, $res);
    }
}