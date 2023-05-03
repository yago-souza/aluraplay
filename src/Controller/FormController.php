<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class FormController
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->saveVideo()
    }
}