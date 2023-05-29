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
        $user = $this->repository->userForEmail($email);
        if ($user === null) {
            $_SESSION['error_message'] = "Usuário ou senha inválidos";
            header('Location: /login');
            exit();
        }
        $correctPassword = password_verify($password, $user->getPassword());
        if($correctPassword){
            /* O if a baixo verifica se a senha está com o hash no modelo
                PASSWORD_ARGON2ID que é o mais atualizado e melhor na
             data de criação desse projeto (10/05/2023)
            Se não estiver com esse hash
            ele adiciona esse hash a senha
            */

            if (password_needs_rehash($user->getPassword(), PASSWORD_ARGON2ID)) {
                $user->setPassword(password_hash($password, PASSWORD_ARGON2ID));
                $this->repository->saveUser($user);
            }
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            // enviar uma mensagem para /login
            $_SESSION['error_message'] = "Usuário ou senha inválidos";
            header('Location: /login');
        }
    }
}