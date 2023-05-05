<?php

declare(strict_types=1);

use Yago\Aluraplay\Controller\{Controller,
    EditVideoController,
    Error404Controller,
    VideoFormController,
    NewVideoController,
    DeleteVideoController,
    VideoListController};
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;
use Yago\Aluraplay\Infrastructure\Repository\UserRepository;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();
$videoRepository = new VideoRepository($pdo);
$userRepository = new UserRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php';
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

session_start();
$isLoginRoute = $pathInfo === '/login';
if(!array_key_exists('logado', $_SESSION) && !$isLoginRoute) {
    header('Location: /login');
    return;
}

$key = "$httpMethod|$pathInfo";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];

    if ($pathInfo == '/login') {
        $controller = new $controllerClass($userRepository);
    } else {
    $controller = new $controllerClass($videoRepository);
    }
} else {
    $controller = new Error404Controller();
}
/** @var Controller $controller */
$controller->processaRequisicao();