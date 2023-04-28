<?php


use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: /?sucesso=0');
    exit();
}

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false || $url === null) {
    header('Location: /?sucesso=0');
    exit();
}

$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false || $titulo === null) {
    header('Location: /?sucesso=0');
    exit();
}

$repository = new VideoRepository($pdo);

if ($repository->saveVideo(new Video($id, $titulo, $url)) === false) {
    header("Location: /?sucesso=0");
} else {
    header("Location: /?sucesso=1");
};