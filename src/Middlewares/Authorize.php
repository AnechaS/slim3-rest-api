<?php

namespace App\Middlewares;

use Firebase\JWT\JWT;
use App\Models\User;
use Exception;
use DomainException;
use UnexpectedValueException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class Authorize {

    public function __invoke($req, $res, $next) {
        $pattern = '/^Bearer:(\s){1,}/';
        $response = [
            'message' => 'Unauthorized'
        ];
        
        $token = $req->getHeaderLine('authorization');

        
        if (!$token) {
            return $res->withJson($response, 401);
        }

        if ($token && !preg_match($pattern, $token)) {
            return $res->withJson(['message' => 'Invalid token'], 401);
        }

        try {
            $token = preg_replace($pattern, '', $token);
            $tokenDecoded = JWT::decode($token, getenv("JWT_SECRET"), array('HS256'));     
        } catch (Exception $e) {
            if ($e instanceof ExpiredException) {
                return $res->withJson(['message' => 'Expired token'], 401);
            }

            if (
                $e instanceof DomainException ||
                $e instanceof SignatureInvalidException ||
                $e instanceof UnexpectedValueException
            ) {
                return $res->withJson(['message' => 'Invalid token'], 401);
            }

            return $res->withJson($response, 401);
        }

        $user = User::find($tokenDecoded->id);
        if (!$user) {
            return $res->withJson($response, 401);
        }

        $req = $req->withAttribute('user', $user->toArray());

        return $next($req, $res);
    }
}