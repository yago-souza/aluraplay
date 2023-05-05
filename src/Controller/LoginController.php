<?php

namespace Yago\Aluraplay\Controller;


use Yago\Aluraplay\Infrastructure\Repository\UserRepository;

class LoginController implements Controller
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $statement = $this->repository->userForEmail($email);
        if ($statement === null) {
            header('Location: /login?sucesso=0');
            exit();
        }
        $correctPassword = password_verify($password, $statement->getPassword());
        if($correctPassword){
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}