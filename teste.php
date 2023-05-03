<?php

use Yago\Aluraplay\Domain\Model\User;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;
use Yago\Aluraplay\Infrastructure\Repository\UserRepository;

require_once 'vendor/autoload.php';
$pdo = ConnectionCreator::createConnection();

$teste = new User(2, 'yago', '123@123');
$repositorio = new UserRepository($pdo);
$repositorio->saveUser($teste);
#$repositorio->removeUser($teste);
var_dump($repositorio->allUsers());