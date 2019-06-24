<?php
namespace App\Controller;

use App\Repository\ProductRepository;
use App\Utilities\AbstractController;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;


class ProductController extends AbstractController
{
    private $repository;

    public function __construct(Twig $twig, ProductRepository $repository)
    {
        parent::__construct($twig);
        $this->repository = $repository;
    }


    public function liste (RequestInterface $request, ResponseInterface $response)
    {
        $products = $this->repository->findAll();
        return $this->twig->render($response,'Produit/list.twig', [
            'products' => $products
        ]);
    }
    public function show (RequestInterface $request, ResponseInterface $response, array $args)
    {
        $produit = $this->repository->findById($args['id']);
        if (!$produit){
            throw new \Exception("Pas de produit trouvé");
        }
        return $this->twig->render($response,'Produit/show.twig', [
            "produit" => $produit
        ]);
    }
    /*
    public function modif (ServerRequestInterface $request, Response $response, array $args)
    {
         return $this->twig->render($response,'Produit/modif.twig', [
             "id" => $args['id']
         ]);
    }
    */
    public function delete (RequestInterface $request, ResponseInterface $response, array $args)
    {
        $status = $this->repository->deleteById([$args['id']]);
        if ($status == 0){
            throw new \Exception("Pas de produit à supprimer");
        }
        return $this->twig->render($response,'Produit/delete.twig', [
            "id" => $args['id'],
            "status"=>$status
        ]);
    }
}
