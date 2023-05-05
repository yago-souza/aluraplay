<?php

namespace Yago\Aluraplay\Controller;

class LogoutController implements Controller
{
    public function processaRequisicao(): void
    {
        if ($_SESSION['logado'] === true){
            unset($_SESSION['logado']);
            #$_SESSION['logado'] = false;
            #as duas linhas a cima fazem a mesma coisa que o session_destroy, mas de forma mais segura
            #session_destroy();
            header('Location: /login');
        }
    }
}