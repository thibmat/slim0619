<?php

use App\Controller\AuthController;
use App\Controller\IndexController;
use App\Controller\JsonController;
use App\Controller\ContactController;
use App\Controller\ProductController;


//Création d'une route
$app->get('/', IndexController::class . ':index');
$app->get('/contact', ContactController::class . ':listcontact');
$app->get('/json', JsonController::class . ':Json');
$app->group('/produit', function (){
    //Création d'une route possédant une variable
    $this->get('/liste', ProductController::class . ':liste' );
    //Création d'une route possédant une variable
    $this->get('/{id:\d+}', ProductController::class . ':show');
    // Création d'une route de modification de produit
    $this->get('/modif/{id:\d+}', ProductController::class . ':modif');
    // Création d'une route de suppession de produit
    $this->get('/delete/{id:\d+}', ProductController::class . ':delete');
});
//Creation d'une route de connexion
$app->get('/inscription', AuthController::class . ':register');
$app->get('/connection', AuthController::class . ':connect');


