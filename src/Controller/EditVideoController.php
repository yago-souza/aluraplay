<?php

namespace Yago\Aluraplay\Controller;

use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class EditVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao():void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            exit();
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            header('Location: /?sucesso=0');
            exit();
        }

        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false || $titulo === null) {
            header('Location: /?sucesso=0');
            exit();
        }

        $video = new Video($id, $titulo, $url, null);


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
        };
    }
}