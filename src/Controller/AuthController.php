<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Utilities\AbstractController;
use App\Utilities\FormValidator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class AuthController extends AbstractController
{
    private $repository;

    public function __construct(Twig $twig, UserRepository $repository)
    {
        parent::__construct($twig);
        $this->repository = $repository;
    }
    public function liste (RequestInterface $request, ResponseInterface $response)
    {
        $users = $this->repository->findAll();
        return $this->twig->render($response,'User/list.twig', [
            'users' => $users
        ]);
    }
    public function register (RequestInterface $request, ResponseInterface $response)
    {
        return $this->twig->render($response,'User/register.twig');
    }

    public function login(RequestInterface $request, ResponseInterface $response)
    {
        $user = '';
        $errorMessage = 'Il y a eu un soucis lors de la connexion';
        $success = 0;
        $errorMessageEmail = null ;
        $errorMessagePassword = null ;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errorMessageEmail = FormValidator::checkPostEmail('email', 255);
            $errorMessagePassword = FormValidator::checkPostText('password', 128);
            if (empty($errorMessageEmail) && empty($errorMessagePassword)) {
                // Il n'y a pas d'erreur, on passe à l'inscription
                $user = $this->repository->findByEmail($_POST['email']);
                if ($user) {
                    if (password_verify($_POST['password'], $user->getUserPassword())) {
                        $_SESSION['user_name']= $user->getUserName();
                        $_SESSION['user_role'] = $user->getUserRoleRoleId();
                        $_SESSION['user_id']= $user->getUserId();
                        $success = 1;
                    } else {
                        $errorMessage = 'Le mot de passe rentré ne correspond pas';
                    }
                } else {
                    $errorMessage = 'Nous n\'avons pas trouvé d\'utilisateur avec ce mail';
                }
            }
        }
        return $this->twig->render($response,'User/login.twig',[
            'user' => $user,
            'errorMessage' => $errorMessage,
            'errorMessageEmail' => $errorMessageEmail,
            'errorMessagePassword' => $errorMessagePassword,
            'success'=> $success
        ]);
    }
}