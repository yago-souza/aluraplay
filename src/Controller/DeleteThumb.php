<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class DeleteThumb implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            exit();
        }
        $video = $this->videoRepository->find($id);
        if ($this->videoRepository->removeThumb($video) === false) {
            header("Location: /?sucesso=0");
        } else {
            header("Location: /?sucesso=1");
        }
    }
}