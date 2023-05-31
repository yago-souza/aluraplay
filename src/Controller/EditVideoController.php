<?php

namespace Yago\Aluraplay\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yago\Aluraplay\Domain\Model\Video;
use Yago\Aluraplay\Helper\FlashMessageTrait;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class EditVideoController implements Controller
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $uploadedFiles = $request->getUploadedFiles();
        $parsedBody =  $request->getParsedBody();
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addErrorMesage("ID inválido");
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $url = filter_var($parsedBody['url'], FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            $this->addErrorMesage("Url inválida");
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $titulo = filter_var($parsedBody['titulo']);
        if ($titulo === false || $titulo === null) {
            $this->addErrorMesage("Título inválido");
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $video = new Video($id, $titulo, $url, null);

        if ($uploadedFiles['image']['error'] === UPLOAD_ERR_OK/*algum video fo enviado*/) {
            # Extrai para uma variavel apenas o nome do arquivo, sem o caminho "__DIR__" ex. /../../nome.jpg
            $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedFiles['image']['name'], PATHINFO_BASENAME);
            # Verifica se os primeiros bites desse arquivo são do tipo de uma imagem
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($uploadedFiles['image']['tmp_name']);

            ## Se começar com uma imaggem ele move o arquivo
            if (str_starts_with($mimeType, 'image/')) {
                move_uploaded_file(
                    $uploadedFiles['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setFilePath($safeFileName);
            }
        }

        if ($this->videoRepository->saveVideo($video) === false) {
            $this->addErrorMesage("Erro ao salvar vídeo");
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        };
    }
}