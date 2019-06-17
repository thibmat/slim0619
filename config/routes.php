<?php


use App\Controller\IndexController;
use App\Controller\Page2Controller;
use App\Controller\ProductController;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

//Création d'une route
$app->get('/homepage', IndexController::class . ':index');
$app->get('/page2', Page2Controller::class . ':index2');
$app->get('/json', JsonController::class . ':Json');
$app->group('/produit', function (){
    //Création d'une route possédant une variable
    $this->get('/liste', ProductController::class . ':liste' );
//Création d'une route possédant une variable
    $this->get('/{id:\d+}', ProductController::class . ':show');
});
