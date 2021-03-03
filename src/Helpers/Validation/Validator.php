<?php

namespace App\Helpers\Validation;

use Illuminate\Validation;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\ConnectionResolver;

use App\Helpers\Translation\Translator;


class Validator {

    static public function make(array $data, array $rules, array $messages = [], array $customAttributes = []) {
        $validation = new Validation\Factory(new Translator);

        $db = new ConnectionResolver(['default' => DB::connection()]);
        $db->setDefaultConnection('default');
        $validation->setPresenceVerifier(new Validation\DatabasePresenceVerifier($db));

        $validator = $validation->make($data, $rules, $messages, $customAttributes);
        return $validator;
    }
}