<?php

namespace Yago\Aluraplay\Infrastructure\Repository;

use PDO;
use Yago\Aluraplay\Domain\Model\Video;

class  PdoVideoRepository
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

    private function hydrateVideosList(\PDOStatement $statement): array
    {
        $videoDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $videoList = [];

        foreach ($videoDataList as $videoData) {
            $videoList[] = new Video(
                $videoData['id'],
                $videoData['title'],
                $videoData['url']
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
        $insertQuery = 'INSERT INTO videos (title, url) VALUES (:titulo, :url);';
        $statement = $this->connection->prepare($insertQuery);

        $success = $statement->execute([
            ':titulo' => $video->getTitulo(),
            ':url' => $video->getUrl(),
        ]);

        if ($success) {
            $video->setId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Video $video)
    {
        $updateQuery = 'UPDATE videos SET title = :titulo, url = :url WHERE id = :id';
        $statement = $this->connection->prepare($updateQuery);
        $statement->bindValue(':id', $video->getId(), PDO::PARAM_INT);
        $statement->bindValue(':titulo', $video->getTitulo());
        $statement->bindValue(':url', $video->getUrl());

        return $statement->execute();
    }

    public function remove(int $id): bool
    {
        $statement = $this->connection->prepare('DElETE FROM videos WHERE id = ?;');
        $statement->bindValue(1, $id, PDO::PARAM_INT);

        return $statement->execute();
    }

}