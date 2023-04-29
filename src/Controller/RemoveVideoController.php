<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class RemoveVideoController
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao():void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            exit();
        }

        if ($this->videoRepository->remove($id) === false) {
            header("Location: /index.php?sucesso=0");
        } else {
            header("Location: /index.php?sucesso=1");
        };
    }
}