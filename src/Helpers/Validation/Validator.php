<?php

namespace App\Helpers\Validation;

use Illuminate\Validation;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\ConnectionResolver;

use App\Helpers\Translation\Translator;

class Validator {

    static public function make(array $data, array $rules, array $messages = [], array $customAttributes = []) {
        $validation = new Validation\Factory(new Translator);

        // Todo not use variable global in method.
        global $capsule;
        $connection = $capsule->getConnection();
        $db = new ConnectionResolver(['default' => $connection]);
        $db->setDefaultConnection('default');
        $validation->setPresenceVerifier(new Validation\DatabasePresenceVerifier($db));

        $validator = $validation->make($data, $rules, $messages, $customAttributes);
        return $validator;
    }
}