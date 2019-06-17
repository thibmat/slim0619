<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

class ProductController
{
    public function liste (ServerRequestInterface $request, Response $response)
    {
        $response = $response->getBody()->write('<h1>Liste des produits</h1>');
        return $response;
    }
    public function show (ServerRequestInterface $request, Response $response, array $args)
    {
        $response = $response->getBody()->write("<h1>Detail du produit : {$args['id']}</h1>");
        return $response;
    }
}
