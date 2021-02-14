<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Validation\Validator;
use DateTime;
use Firebase\JWT\JWT;

class AuthController {

    public function login($request, $response) {
        $body = $request->getParsedBody() ?? [];

        $validate = Validator::make($body, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors();
            return $response->withJson([
                'message' => $errors->all()[0],
            ], 400);
        }

        $user = User::where(['email' => $body['email']])->first();
        if ($user && password_verify($body['password'], $user->password)) {

            $exp = new DateTime("now +5 day");
            $payload = array(
                'exp' => $exp->getTimeStamp(),
                'id' => $user->id
            );
            
            $token = JWT::encode($payload, getenv("JWT_SECRET"));

            return $response->withJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'accessToken' => $token
            ]);
        }

        return $response->withJson(['message' => 'Incorrect email or password'], 401);
    }
}