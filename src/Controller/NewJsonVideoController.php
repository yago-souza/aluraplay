<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class NewJsonVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $request = file_get_contents('php://input');
        $videoData = json_decode($request, true);
        $video = new Video(null, $videoData['title'], $videoData['url'], null);
        $this->videoRepository->saveVideo($video);
        http_response_code(201);
    }
}