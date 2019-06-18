<?php
namespace App\Controller;

use App\Utilities\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;



class JsonController
{

    public function Json(ServerRequestInterface $request, Response $response)
    {
        $hamac = [
            "name" => "hamac",
            "descriptition" => "Pour se reposer"
        ];
        $response = $response->withJson($hamac);
        return $response;
    }
}
