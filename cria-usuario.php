<?php

use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$email = $argv[1];
$password = $argv[2];

$hash = password_hash($password, PASSWORD_ARGON2ID);

$sql = 'INSERT INTO users (email, password) VALUES (:email, :password);';
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email);
$statement->bindValue(':password', $hash);
$statement->execute();