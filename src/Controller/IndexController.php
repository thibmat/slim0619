<?php
namespace App\Controller;

use App\Utilities\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController extends AbstractController
{

    public function index (ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->twig->render($response,'index.twig');
    }
}
