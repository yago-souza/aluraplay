<?php


use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: /?sucesso=0');
    exit();
}

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false || $url === null) {
    header('Location: /?sucesso=0');
    exit();
}

$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false || $titulo === null) {
    header('Location: /?sucesso=0');
    exit();
}

$sql = 'UPDATE videos SET url = :url, title = :titulo WHERE id = :id;';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->bindValue(':url', $url);
$statement->bindValue(':titulo', $titulo);
$statement->execute();

if ($statement->execute() === false) {
    header("Location: /?sucesso=0");
} else {
    header("Location: /?sucesso=1");
};