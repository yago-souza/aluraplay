<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = $_GET['id'];

$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id, PDO::PARAM_INT);
$statement->execute();

if ($statement->execute() === false) {
    header("Location: /?sucesso=0");
} else {
header("Location: /?sucesso=1");
};