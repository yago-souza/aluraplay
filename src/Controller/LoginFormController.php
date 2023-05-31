<?php

namespace Yago\Aluraplay\Controller;


use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yago\Aluraplay\Helper\HtmlRendererTrait;

class LoginFormController implements Controller
{
    use HtmlRendererTrait;
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            return new Response(302,[
                'Location' => '/'
                ]);
        }
        return new Response(200, body: $this->renderTemplate('login-form'));
    }
}