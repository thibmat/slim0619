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

$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function (ContainerInterface $c) {
    $view = new Twig(
        dirname(__DIR__).'/templates',
        [
            'cache' => false
        ]
    );

    // Instantiate and add Slim specific extension
    $router = $c->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new TwigExtension($router, $uri));

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