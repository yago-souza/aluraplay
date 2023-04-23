<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = $_GET['id'];
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header("Location: /index.php?sucesso=0");
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');
/*
var_dump($id);
var_dump($url);
var_dump($titulo);
exit();*/

$sql = 'UPDATE videos SET url = :url, title = :titulo WHERE id = :id;';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->bindValue(':url', $url);
$statement->bindValue(':titulo', $titulo);
$statement->execute();

if ($statement->execute() === false) {
    header("Location: /index.php?sucesso=0");
} else {
    header("Location: /index.php?sucesso=1");
};