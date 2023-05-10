<?php

use Yago\Aluraplay\Domain\Model\User;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;
use Yago\Aluraplay\Infrastructure\Repository\UserRepository;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

require_once 'vendor/autoload.php';
$pdo = ConnectionCreator::createConnection();

#$teste = new User(2, 'yago@teste.com', '123@123');
$repositorioUsuarios = new UserRepository($pdo);
$videoRepository = new VideoRepository($pdo);
#$repositorio->saveUser($teste);
#$repositorio->removeUser($teste);
#var_dump($repositorio->allUsers());
#var_dump($repositorio->userForEmail("yago@teste.com")->getEmail());
$video = $videoRepository->allVideos()[2];

var_dump($video);
