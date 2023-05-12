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
## Serve para renovar o ID do cookie e protejer contra sequestro de sessão
## Conferir documentação como fazer isso de forma mais confiavel
if (isset($_SESSION['logado'])) {
    $originalInfo = $_SESSION['logado'];
    unset($_SESSION['logado']);
    session_regenerate_id();
    $_SESSION['logado'] = $originalInfo;
}
## Dessa forma, a sessão anterior não terá mais a informação de autenticação
# e a nova sessão terá a informação que já havia sido salva.

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