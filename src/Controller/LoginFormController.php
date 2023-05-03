<?php

namespace Yago\Aluraplay\Controller;

class LoginFormController implements Controller
{
    public function processaRequisicao(): void
    {
        require_once __DIR__ . '/../../views/login-form.php';
    }
}