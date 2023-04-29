<?php

declare(strict_types=1);

use Yago\Aluraplay\Controller\FormController;
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
        #require_once __DIR__ . '/../formulario.php';
        $formController->processaRequisicao();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../novo-video.php';
    }
} elseif ($_SERVER['PATH_INFO'] === '/editar-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        #require_once __DIR__ . '/../formulario.php';
        $formController->processaRequisicao();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../edita-video.php';
    }
} elseif ($_SERVER['PATH_INFO'] === '/remover-video') {
    require_once __DIR__ . '/../remover-video.php';
} else {
    http_response_code(404);
}