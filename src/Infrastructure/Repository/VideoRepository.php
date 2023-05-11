<?php

namespace Yago\Aluraplay\Infrastructure\Repository;

use PDO;
use Yago\Aluraplay\Domain\Model\Video;

class  VideoRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allVideos(): array
    {
        $sqlQuery = 'SELECT * FROM videos;';
        $statement = $this->connection->query($sqlQuery);

        return $this->hydrateVideosList($statement);
    }

    public function videoForId(int $id)
    {
        $statement = $this->connection->prepare('SELECT * FROM videos WHERE id = ?;');
        $statement->bindValue(1,$id, PDO::PARAM_INT);
        $statement->execute();

        $returnStatement = $statement->fetch(PDO::FETCH_ASSOC);
        $video = new Video( $returnStatement['id'], $returnStatement['title'], $returnStatement['url'], $returnStatement['image_path']);

        return $video;
    }

    private function hydrateVideosList(\PDOStatement $statement): array
    {
        $videoDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $videoList = [];

        foreach ($videoDataList as $videoData) {
            $videoList[] = new Video(
                $videoData['id'],
                $videoData['title'],
                $videoData['url'],
                $videoData['image_path']
            );
        }
        return $videoList;
    }

    public function saveVideo(Video $video): bool
    {
        if ($video->getId() === null) {
            return $this->insert($video);
        }

        return $this->update($video);
    }

    private function insert(Video $video): bool
    {
        $insertQuery = 'INSERT INTO videos (title, url, image_path) VALUES (:titulo, :url, :image_path);';
        $statement = $this->connection->prepare($insertQuery);

        $success = $statement->execute([
            ':titulo' => $video->getTitulo(),
            ':url' => $video->getUrl(),
            ':image_path' => $video->getFilePath(),
        ]);

        if ($success) {
            $video->setId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Video $video)
    {
        $updateImageSql = '';
        if ($video->getFilePath() !== null) {
            $updateImageSql = ', image_path = :image_path';
        }
        $updateQuery = "UPDATE videos SET
                            url = :url,
                            title = :titulo
                            $updateImageSql
                        WHERE id = :id";
        $statement = $this->connection->prepare($updateQuery);
        $statement->bindValue(':id', $video->getId(), PDO::PARAM_INT);
        $statement->bindValue(':url', $video->getUrl());
        $statement->bindValue(':titulo', $video->getTitulo());

        if ($video->getFilePath() !== null) {
            $statement->bindValue(':image_path', $video->getFilePath());
        }


        return $statement->execute();
    }

    public function remove(int $id): bool
    {
        $statement = $this->connection->prepare('DElETE FROM videos WHERE id = ?;');
        $statement->bindValue(1, $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function removeThumb(Video $video): bool
    {
        $sql = 'UPDATE VIDEOS SET image_path = NULL WHERE id = ?;';
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1,$video->getId());

        return $statement->execute();
    }

}