<?php
namespace App\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Page2Controller
{
    public function index2(ServerRequestInterface $request, ResponseInterface $response)
    {
        $headers = $request->getHeaders();
        $response = $response->getHeaders();
        var_dump($headers);
        var_dump($response);
    }

}
