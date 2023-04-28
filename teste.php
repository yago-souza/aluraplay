<?php

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();
#$teste = new Video(6, 'teste', 'teste');

$teste = new VideoRepository($pdo);
$repositorio = $teste->allVideos();

foreach ($repositorio as $video) {
    var_dump($video->getId());
    #var_dump($video->getUrl);
}