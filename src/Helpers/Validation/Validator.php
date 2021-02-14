<?php

namespace App\Helpers\Validation;

use Illuminate\Validation;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\ConnectionResolver;


class Validator {

    static public function make(array $data, array $rules, array $messages = [], array $customAttributes = []) {
        $path = dirname(__DIR__, 2) . '/Lang';
        $filesystem = new Filesystem();
        $filesLoader = new Translation\FileLoader($filesystem,  $path);
        $filesLoader->addNamespace('lang', $path);
        $filesLoader->load('en', 'validation', 'lang');
        $translator = new Translation\Translator($filesLoader, 'en');
        $validation = new Validation\Factory($translator);

        global $capsule;
        $connection = $capsule->getConnection();
        $db = new ConnectionResolver(['default' => $connection]);
        $db->setDefaultConnection('default');
        $validation->setPresenceVerifier(new DatabasePresenceVerifier($db));
        
        $validator = $validation->make($data, $rules, $messages, $customAttributes);

        return $validator;
    }
}