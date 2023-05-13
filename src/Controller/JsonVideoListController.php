<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class JsonVideoListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->allVideos();
        #var_dump($videoList);
        echo json_encode($videoList);
    }
}