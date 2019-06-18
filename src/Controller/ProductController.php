<?php
namespace App\Controller;

use App\Entity\Produit;
use App\Utilities\AbstractController;
use App\Utilities\Database;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;


class ProductController extends AbstractController
{
    public function liste (ServerRequestInterface $request, Response $response)
    {
        $database = new Database();
        $query = "SELECT * FROM produit WHERE etat_publication = 1";
        $products = $database->query($query, Produit::class);
        return $this->twig->render($response,'Produit/list.twig', [
            'products' => $products
        ]);
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
