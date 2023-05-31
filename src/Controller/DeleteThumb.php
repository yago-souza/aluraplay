<?php

namespace Yago\Aluraplay\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yago\Aluraplay\Helper\FlashMessageTrait;
use Yago\Aluraplay\Infrastructure\Repository\VideoRepository;

class DeleteThumb implements Controller
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            exit();
        }
        $video = $this->videoRepository->find($id);
        if ($this->videoRepository->removeThumb($video) === false) {
            $this->addErrorMesage('Erro ao remover thumb');
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}