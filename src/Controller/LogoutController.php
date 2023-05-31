<?php

namespace Yago\Aluraplay\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutController implements Controller
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        if ($_SESSION['logado'] === true){
            unset($_SESSION['logado']);
            #$_SESSION['logado'] = false;
            #as duas linhas a cima fazem a mesma coisa que o session_destroy, mas de forma mais segura
            #session_destroy();
            return new Response(302, [
                'Location' => '/login'
            ]);
        }
    }
}