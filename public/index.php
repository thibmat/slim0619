<?php

//Récupération de l'autoloader créé par Slim
require dirname(__DIR__) . '/vendor/autoload.php';
//Les Uses des différentes classes
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;


// On crée l'application de Slim
$app = new app();

//Création d'une route
$app->get('/homepage',function (ServerRequestInterface $request, ResponseInterface $response)
{
        $response = $response->getBody()->write('<h1>Bonjour</h1>');
    return $response;
});

$app->run();