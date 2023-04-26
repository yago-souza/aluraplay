<?php

namespace Yago\Aluraplay\Infrastructure\Persistence;


use PDO;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $databasePath =__DIR__ . '/../../../banco.sqlite';
        $connection = new PDO('sqlite:' . $databasePath);
        ## Faz com que o PDO lance excessões se tornou o modo padrão do ATTR_ERRMODE A PARTIR DA VERSÃO 8
        #$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        #Define o FETCH MODE para ASSOCIATIVE como padrão
        #$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $connection;
    }
}