<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
    public function find($request, $response) {
        $users = User::all();
        return $response->withJson(['results' => $users->toArray()]);
    }

    public function create($request, $response) {
        return $response->withJson([], 201);
    }

    public function get($request, $response, $args) {
        return $response->withJson([]);
    }

    public function update($request, $response, $args) {
        return $response->withJson([]);
    }

    public function delete($request, $response, $args) {
        return $response->withJson([], 204);
    }
}