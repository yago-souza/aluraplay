<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = $_GET['id'];
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /?sucesso=0');
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');

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