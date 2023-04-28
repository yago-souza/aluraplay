<?php

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();
#$teste = new Video(6, 'teste', 'teste');

$statement = new VideoRepository($pdo);
$video = $statement->videoPorId(2);

var_dump($video);