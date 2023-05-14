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
        $videoListJson = [];
        foreach ($videoList as $video) {
            $arrayVideo = [
                "id" => $video->getId(),
                "titulo" => $video->getTitulo(),
                "url" => $video->getUrl(),
                "filePath" => '/img/uploads/' . $video->getFilePath(),
            ];
            $videoListJson[] = json_encode($arrayVideo);
            echo json_encode($arrayVideo) . "<br>";
        }
        #var_dump($videoListJson);
    }
}