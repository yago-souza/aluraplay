<?php

namespace Yago\Aluraplay\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Controller
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface;
}