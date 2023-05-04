<?php

namespace Yago\Aluraplay\Controller;


use Yago\Aluraplay\Infrastructure\Repository\UserRepository;

class LoginController2 implements Controller
{

    public function __construct(private UserRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $statement = $this->repository->userForEmail($email);
        var_dump($statement);
        exit();
        if (password_verify($password, $statement->getPassword())) {
            header('Location: /');
        } else {
            header('Location: /login?sucesso=0');
        }
    }
}