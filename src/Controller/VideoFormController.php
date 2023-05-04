<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class VideoFormController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $video = null;#new Video(null, '', '');
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->videoForId($id);
        }
        require_once __DIR__ . '/../../views/video-form.php';
    }
}