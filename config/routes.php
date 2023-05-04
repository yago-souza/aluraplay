<?php

return [
    'GET|/' => \Yago\Aluraplay\Controller\VideoListController::class,
    'GET|/novo-video' => \Yago\Aluraplay\Controller\VideoFormController::class,
    'POST|/novo-video' => \Yago\Aluraplay\Controller\NewVideoController::class,
    'GET|/editar-video' => \Yago\Aluraplay\Controller\VideoFormController::class,
    'POST|/editar-video' => \Yago\Aluraplay\Controller\EditVideoController::class,
    'GET|/remover-video' => \Yago\Aluraplay\Controller\DeleteVideoController::class,
    'GET|/login' => \Yago\Aluraplay\Controller\LoginFormController::class,
    'POST|/login' => \Yago\Aluraplay\Controller\LoginController2::class,
];