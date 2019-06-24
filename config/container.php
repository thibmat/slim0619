<?php
// Fetch DI Container
use App\Controller\AuthController;
use App\Controller\IndexController;
use App\Controller\ContactController;
use App\Controller\ProductController;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Twig\StringFilter;
use App\Utilities\Database;
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
    $view->addExtension(new DebugExtension());
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new TwigExtension($router, $uri));
    $basePath = rtrim(str_ireplace('index.php','',$uri),'/');
    $view->addExtension(new StringFilter($c->get('router'), $basePath));
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
$container[database::class] = function(ContainerInterface $container)
{
    return new Database($container['settings']['database']);
};
$container[ProductRepository::class]=function(ContainerInterface $container)
{
  return new ProductRepository($container->get(Database::class));
};
$container[ProductController::class] = function(ContainerInterface $container)
{
    return new ProductController($container->get('view'),$container->get(ProductRepository::class));
};
$container[UserRepository::class]=function(ContainerInterface $container)
{
    return new UserRepository($container->get(Database::class));
};
$container[AuthController::class] = function(ContainerInterface $container)
{
    return new AuthController($container->get('view'),$container->get(UserRepository::class));
};