<?php

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header("Location: /?sucesso=0");
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');

$repository = new VideoRepository($pdo);

if ($repository->saveVideo(new Video(null, $titulo, $url)) === false) {
    header("Location: /?sucesso=0");
} else {
    header("Location: /?sucesso=1");
};

