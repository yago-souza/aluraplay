<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Helper\HtmlRendererTrait;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class VideoFormController implements Controller
{
    use HtmlRendererTrait;
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->find($id);
        }

        echo $this->renderTemplate(
            'video-form',
                        ['video' => $video]
        );
    }
}