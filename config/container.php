<?php
// Fetch DI Container
use App\Controller\AuthController;
use App\Controller\IndexController;
use App\Controller\ContactController;
use App\Controller\ProductController;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Extension\DebugExtension;

$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function (ContainerInterface $c) {
    $view = new Twig(
        dirname(__DIR__).'/templates',
        [
            'cache' => false,
            'debug' => true
        ]
    );

    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new TwigExtension($router, $uri));
    $view->addExtension(new DebugExtension());
    // Ajout de variables globales
    $view->getEnvironment()->addGlobal('session', $_SESSION);

    return $view;
};

$container[IndexController::class] = function(ContainerInterface $container)
{
  return new IndexController($container->get('view'));
};
$container[ContactController::class] = function(ContainerInterface $container)
{
    return new ContactController($container->get('view'));
};
$container[ProductController::class] = function(ContainerInterface $container)
{
    return new ProductController($container->get('view'));
};
$container[AuthController::class] = function(ContainerInterface $container)
{
    return new AuthController($container->get('view'));
};