<?php

declare(strict_types=1);

use Yago\Aluraplay\Controller\EditaVideoController;
use Yago\Aluraplay\Controller\FormController;
use Yago\Aluraplay\Controller\NovoVideoController;
use Yago\Aluraplay\Controller\RemoveVideoController;
use Yago\Aluraplay\Controller\VideoListController;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';
/*
$pdo = ConnectionCreator::createConnection();
$videoRepository = new VideoRepository($pdo);
*/
$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideoRepository($pdo);
$formController = new FormController($videoRepository);

if (!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/') {
   $controller = new VideoListController($videoRepository);
   $controller->processaRequisicao();
} elseif ($_SERVER['PATH_INFO'] === '/novo-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $formController->processaRequisicao();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $novoVideo = new NovoVideoController($videoRepository);
        $novoVideo->processaRequisicao();
    }
} elseif ($_SERVER['PATH_INFO'] === '/editar-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $formController->processaRequisicao();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $editaVideo = new EditaVideoController($videoRepository);
        $editaVideo->processaRequisicao();
    }
} elseif ($_SERVER['PATH_INFO'] === '/remover-video') {
    $removeVideo = new RemoveVideoController($videoRepository);
    $removeVideo->processaRequisicao();
} else {
    http_response_code(404);
}