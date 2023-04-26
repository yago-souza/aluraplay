<?php

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Repository\PdoVideoRepository;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();
#$teste = new Video(6, 'teste', 'teste');

$teste = new PdoVideoRepository($pdo);
var_dump($teste->allVideos());