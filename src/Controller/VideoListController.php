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
        require_once __DIR__ . '/../../inicio-html.php';
        ?>
        <ul class="videos__container">
            <?php foreach ($videoList as $video): ?>
            <li class="videos__item">
                <iframe width="100%" height="72%" src="<?= $video->getUrl(); ?>"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
                <div class="descricao-video">
                    <img src="./img/logo.png" alt="logo canal alura">
                    <h3><?= $video->getTitulo(); ?></h3>
                    <div class="acoes-video">
                        <a href="./editar-video?id=<?=$video->getId(); ?>">Editar</a>
                        <a href="./remover-video?id=<?=$video->getId(); ?>">Excluir</a>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php require_once __DIR__ . '/../../fim-html.php';
    }
}