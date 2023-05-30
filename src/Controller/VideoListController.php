<?php

namespace Yago\Aluraplay\Controller;

use PDO;
use Yago\Aluraplay\Helper\HtmlRendererTrait;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class VideoListController implements Controller
{
    use HtmlRendererTrait;
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->allVideos();
        echo $this->renderTemplate(
            'video-list',
            ['videoList' => $videoList]
        );
    }
}