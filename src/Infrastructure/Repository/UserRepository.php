<?php

namespace Yago\Aluraplay\Infrastructure\Repository;

use PDO;
use Yago\Aluraplay\Domain\Model\Video;

class UserRepository implements \Alura\Domain\Repository\UserRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function allUsers(): array
    {
        $sqlQuery = 'SELECT * FROM users;';
        $statement = $this->connection->query($sqlQuery);

        return $this->hydrateUsersList($statement);
    }

    public function userForId(Video $user): Video
    {
        $statement = $this->connection->prepare('SELECT * FROM users WHERE id = ?;');
        $statement->bindValue(1,$user->getId(), PDO::PARAM_INT);
        $statement->execute();

        $returnStatement = $statement->fetch(PDO::FETCH_ASSOC);
        $userConsulted = new Video( $returnStatement['id'], $returnStatement['email'], $returnStatement['password']);

        return $userConsulted;
    }

    private function hydrateUsersList(\PDOStatement $statement): array
    {
        $userDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $userList = [];

        foreach ($userDataList as $userData) {
            $userList[] = new Video(
                $userData['id'],
                $userData['email'],
                $userData['password']
            );
        }
        return $userList;
    }

    public function saveUser(Video $user): bool
    {
        if ($user->getId() === null) {
            return $this->insert($user);
        }

        return $this->update($user);
    }

    private function insert(Video $user): bool
    {
        $hash = password_hash($user->getPassword(), PASSWORD_ARGON2ID);
        $insertQuery = 'INSERT INTO users (email, password) VALUES (:email, :password);';
        $statement = $this->connection->prepare($insertQuery);

        $success = $statement->execute([
            ':email' => $user->getEmail(),
            ':password' => $hash,
        ]);

        if ($success) {
            $user->setId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Video $user)
    {
        $updateQuery = 'UPDATE users SET email = :email, password = :password WHERE id = :id';
        $statement = $this->connection->prepare($updateQuery);
        $statement->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $statement->bindValue(':email', $user->getEmail());
        $statement->bindValue(':password', $user->getPassword());

        return $statement->execute();
    }

    public function removeUser(Video $user): bool
    {
        $statement = $this->connection->prepare('DElETE FROM users WHERE id = ?;');
        $statement->bindValue(1, $user->getId(), PDO::PARAM_INT);

        return $statement->execute();
    }

}