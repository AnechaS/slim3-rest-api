<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Validation\Validator;

class UserController {

    public function find($req, $res) {
        $users = User::all();
        return $res->withJson(['results' => $users->toArray()]);
    }

    private function isDuplicateEmail($email) {
        $user = User::where(['email' => $email])->first();
        return $user !== NULL;
    }

    private function validate($data, $roles) {
        $validate = Validator::make($data, $roles);

        if (!$validate->fails()) {
            if ($data['email'] && $this->isDuplicateEmail($data['email'])) {
                $validate->errors->add('email', 'unique', 'The Email has already been taken');
            }
        }

        return $validate;
    }

    public function create($req, $res) {
        $body = $req->getParsedBody();

        $validate = $this->validate($body, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors();
            return $res
                ->withStatus(400)
                ->withJson([
                    'message' => $errors->all()[0],
                ]);
        }

        $user = User::create($body);
        return $res->withJson($user->toArray(), 201);
    }

    public function get($req, $res, $args) {
        $user = User::findOrFail($args['id']);
        return $res->withJson($user->toArray());
    }

    public function update($req, $res, $args) {
        $body = $req->getParsedBody();

        $validate = $this->validate($body, [
            'email' => 'email',
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors();
            return $res
                ->withStatus(400)
                ->withJson([
                    'message' => $errors->all()[0],
                ]);
        }

        $user = User::findOrFail($args['id']);

        foreach ($body as $key => $value) {
            $user->{$key} = $value;
        }

        $user->save();

        return $res->withJson($user->toArray());
    }

    public function delete($req, $res, $args) {
        $user = User::findOrFail($args['id'])->delete();
        return $res->withJson([], 204);
    }
}