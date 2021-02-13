<?php

namespace App\Helpers\Validation;

// use Rakit\Validation\Validator as Validation;

class Validator {
    public static function make(array $inputs = null, array $rules, array $messages = []) {
        $validator = new \Rakit\Validation\Validator();
        $validation = $validator->make($inputs ?? [], $rules, $messages);
        $validation->validate();
        return $validation;
    }
}