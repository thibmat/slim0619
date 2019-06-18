<?php

namespace App\Utilities;

use Slim\Views\Twig;

class AbstractController
{
    /**
     * @var Twig
     */
    protected $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }
}
