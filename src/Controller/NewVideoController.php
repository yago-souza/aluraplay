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
            $_SESSION['error_message'] = "Não foi possivel inserir vídeo. Url inválida";
            header("Location: /novo-video");
            exit();
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if($titulo == false) {
            $_SESSION['error_message'] = "Titulo não informado";
            header('Location: /novo-video');
            return;
        }

        $video = new Video(null, $titulo, $url, null);

        if ($_FILES['image']['error'] === UPLOAD_ERR_OK/*algum video fo enviado*/) {
            # Extrai para uma variavel apenas o nome do arquivo, sem o caminho "__DIR__" ex. /../../nome.jpg
            $safeFileName = uniqid('upload_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
            # Verifica se os primeiros bites desse arquivo são do tipo de uma imagem
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);

            ## Se começar com uma imaggem ele move o arquivo
            if (str_starts_with($mimeType, 'image/')) {
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setFilePath($safeFileName);
            }
        }

        if ($this->videoRepository->saveVideo($video) === false) {
            $_SESSION['error_message'] = "Não foi possivel inserir novo vídeo";
            header("Location: /");
        } else {
            header("Location: /?sucesso=1");
        }


    }
}