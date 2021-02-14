<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Validation\Validator;
use Firebase\JWT\JWT;

class AuthController {

    public function login($request, $response) {
        $body = $request->getParsedBody();

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
            $payload = [
                'id' => $user->id,
            ];

            $token = JWT::encode([ 'id' => $user->id ], getenv("SECRET_KEY"));

            return $response->withJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'accessToken' => $token
            ]);
        }

        return $response->withJson(['message' => 'Incorrect email or password'], 401);
    }

    public function register($request, $response) {
        $body = $request->getParsedBody();

        $validate = Validator::make($body, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors();
            return $response->withJson([
                'message' => $errors->all()[0],
            ], 400);
        }

        // check duplicate email
        if (User::where(['email' => $body['email']])->first()) {
            return $response->withJson([
                'message' => 'The Email has already been taken'
            ], 400);
        }

        $user = User::create([
            'name' => $body['name'],
            'email' => $body['email'],
            'password' => $body['password']
        ]);

        return $response->withJson($user->toArray(), 201);      
    }
}