<?php 

namespace App\Controllers;

class HomeController {

    public function index($request, $response) {
        return $response->withJson(['message' => 'ok']);
    }
}