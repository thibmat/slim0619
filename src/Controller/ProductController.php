<?php
namespace App\Controller;

use App\Utilities\AbstractController;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;


class ProductController extends AbstractController
{
    public function liste (ServerRequestInterface $request, Response $response)
    {
        return $this->twig->render($response,'Produit/list.twig');
    }
    public function show (ServerRequestInterface $request, Response $response, array $args)
    {
        return $this->twig->render($response,'Produit/show.twig', [
            "id" => $args['id']
        ]);
    }
    public function modif (ServerRequestInterface $request, Response $response, array $args)
    {
         return $this->twig->render($response,'Produit/modif.twig', [
             "id" => $args['id']
         ]);
    }
    public function delete (ServerRequestInterface $request, Response $response, array $args)
    {
        return $this->twig->render($response,'Produit/delete.twig', [
            "id" => $args['id']
        ]);
    }
}
