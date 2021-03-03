<?php

namespace App\Helpers\Illuminate;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Validation;
use Illuminate\Database\ConnectionResolver;

class Illuminate {

    static public function init() {
        /**
         * Usage laravel facage laravel facades
         * @see https://stackoverflow.com/questions/53942294/is-it-possible-to-use-laravel-facades-with-illuminate-database-standalone
         */
        $container = new Container;
        Facade::setFacadeApplication($container);

        /**
         * Setup Eloquent
         * @see https://github.com/illuminate/database
         */
        $capsule = new Capsule;
        $capsule->addConnection(
            config(getenv('APP_ENV') !== 'test' ? 'database' : 'database_test')
        );
        $capsule->setEventDispatcher(new Dispatcher($container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $container->singleton('db', function () use ($capsule) {
            return $capsule;
        });

        $container->singleton('validator', function () use ($capsule) {
            /**
             * Setup Illuminate\Validation
             * @see https://github.com/illuminate/validation
             */
            $validation = new Validation\Factory(new Translator);
            $connection = $capsule->getConnection();
            $db = new ConnectionResolver(['default' => $connection]);
            $db->setDefaultConnection('default');
            $validation->setPresenceVerifier(new Validation\DatabasePresenceVerifier($db));
            return $validation;
        });
    }
}