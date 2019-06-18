<?php
namespace App\Controller;

use App\Utilities\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContactController extends AbstractController
{
    public function listcontact (ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->twig->render($response,'contact.twig');
    }
}
