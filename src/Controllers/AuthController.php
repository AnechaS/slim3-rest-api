<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Validation\Validator;

class AuthController {
    public function login($request, $response) {
        $body = $request->getParsedBody();

        $user = User::where(['email' => $body['email']])->first();
        if ($user && password_verify($body['password'], $user->password)) {
            return $response->withJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'accessToken' => 'xxx'
            ]);
        }

        return $response->withJson(['message' => 'Unauthorized'], 401);
    }

    public function register($request, $response) {
        $body = $request->getParsedBody();

        $validate = Validator::make($body, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors();
            return $response->withJson([
                'message' => 'Validation Error',
                'errors' => $errors->firstOfAll()
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