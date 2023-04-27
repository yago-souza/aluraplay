<?php

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;
use Yago\Aluraplay\Infrastructure\Repository\PdoVideoRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header("Location: /?sucesso=0");
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');

$repository = new PdoVideoRepository($pdo);

if ($repository->saveVideo(new Video(null, $titulo, $url)) === false) {
    header("Location: /?sucesso=0");
} else {
    header("Location: /?sucesso=1");
};

