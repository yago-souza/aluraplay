<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class NewVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao():void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            header("Location: /?sucesso=0");
            exit();
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if($titulo == false) {
            header('Location: /?sucesso=0');
            return;
        }

        $video = new Video(null, $titulo, $url, null);

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK/*algum video fo enviado*/) {
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                __DIR__ . '/../../public/img/uploads/' . $_FILES['image']['name']
            );
            $video->setFilePath($_FILES['image']['name']);
        }

        if ($this->videoRepository->saveVideo($video) === false) {
            header("Location: /?sucesso=0");
        } else {
            header("Location: /?sucesso=1");
        }


    }
}