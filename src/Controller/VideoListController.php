<?php

namespace Yago\Aluraplay\Controller;

use PDO;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class VideoListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->allVideos();
        require_once __DIR__ . '/../../views/video-list.php';
    }
}