<?php

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;
use Yago\Aluraplay\Infrastructure\Repository\UserRepository;

require_once 'vendor/autoload.php';
$pdo = ConnectionCreator::createConnection();

$teste = new Video(null, 'yago', 'teste@123');
$repositorio = new UserRepository($pdo);
$repositorio->saveUser($teste);
#$repositorio->remove(2);
var_dump($repositorio->allUsers());