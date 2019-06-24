<?php
session_start();

//Récupération de l'autoloader créé par Slim
require dirname(__DIR__) . '/vendor/autoload.php';
//Les Uses des différentes classes
use Slim\App;

// Récupération de la config pour Slim
$config = require dirname (__DIR__) . '/config/config.php';

// On crée l'application de Slim
$app = new app($config);

// Récupération du container
$container = require dirname (__DIR__) . '/config/container.php';

//Récupération des routes
require dirname(__DIR__) . '/config/routes.php';
$app->run();
