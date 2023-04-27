<?php

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Persistence\ConnectionCreator;
use Yago\Aluraplay\Infrastructure\Repository\PdoVideoRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: /?sucesso=0');
    exit();
}

$repository = new PdoVideoRepository($pdo);

if ($repository->remove($id) === false) {
    header("Location: /index.php?sucesso=0");
} else {
header("Location: /index.php?sucesso=1");
};