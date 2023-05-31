<?php

namespace Yago\Aluraplay\Controller;

use http\Client\Response;
use http\Message\Body;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class JsonVideoListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
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
        return new Response(200, body: $videoListJson);
    }
}