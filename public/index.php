<?php

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$app = require 'src/app.php';
$app->run();