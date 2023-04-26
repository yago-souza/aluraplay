<?php

use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: /?sucesso=0');
    exit();
}

$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id, PDO::PARAM_INT);
$statement->execute();

if ($statement->execute() === false) {
    header("Location: /index.php?sucesso=0");
} else {
header("Location: /index.php?sucesso=1");
};