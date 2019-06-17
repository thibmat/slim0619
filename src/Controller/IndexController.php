<?php
namespace App\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    public function index (ServerRequestInterface $request, ResponseInterface $response)
    {
        $response = $response->getBody()->write('<h1>Bonjour</h1>');
        return $response;
    }


}