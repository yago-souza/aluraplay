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
        //buscar o usuário no banco com email
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST,'password');
        $statement = $this->repository->userForEmail($email);

        $correctPassword = password_verify($password, $statement->getPassword());

        if($correctPassword){
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}