<?php

namespace Yago\Aluraplay\Controller;


use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yago\Aluraplay\Helper\FlashMessageTrait;
use Yago\Aluraplay\Infrastructure\Repository\UserRepository;

class LoginController implements Controller
{
    use FlashMessageTrait;
    public function __construct(private UserRepository $repository)
    {
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $email = filter_var($parsedBody['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($parsedBody['password']);
        $user = $this->repository->userForEmail($email);
        if ($user === null) {
            $this->addErrorMesage("Usuário ou senha inválidos");
            return new Response(302, [
                'Location' => '/login'
            ]);
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
            return new Response(302, [
                'Location' => '/login'
            ]);
        } else {
            // enviar uma mensagem para /login
            $this->addErrorMesage('Usuário ou senha inválidos');
            return new Response(302, [
                'Location' => '/login'
            ]);
        }
    }
}