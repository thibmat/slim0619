<?php

//Récupération de l'autoloader créé par Slim
require dirname(__DIR__) . '/vendor/autoload.php';
//Les Uses des différentes classes

use Slim\App;

$config = require dirname (__DIR__) . '/config/config.php';

// On crée l'application de Slim
$app = new app($config);

require dirname(__DIR__) . '/config/routes.php';

$app->run();