<?php

namespace Yago\Aluraplay\Infrastructure\Repository;

use PDO;
use Yago\Aluraplay\Domain\Model\User;

class UserRepository implements \Yago\Aluraplay\Domain\Repository\UserRepository
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

    public function userForEmail(string $email): ? User
    {
            $statement = $this->connection->prepare('SELECT * FROM users WHERE email = ?;');
            $statement->bindValue(1,$email);
            $statement->execute();

            $returnStatement = $statement->fetch(PDO::FETCH_ASSOC);
            if ($returnStatement) {
                $user = new User( $returnStatement['id'], $returnStatement['email'], $returnStatement['password']);

                return $user;
            } else return null;
    }

    private function hydrateUsersList(\PDOStatement $statement): array
    {
        $userDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $userList = [];

        foreach ($userDataList as $userData) {
            $userList[] = new User(
                $userData['id'],
                $userData['email'],
                $userData['password']
            );
        }
        return $userList;
    }

    public function saveUser(User $user): bool
    {
        if ($user->getId() === null) {
            return $this->insert($user);
        }

        return $this->update($user);
    }

    private function insert(User $user): bool
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

    private function update(User $user)
    {
        $hash = password_hash($user->getPassword(), PASSWORD_ARGON2ID);
        $updateQuery = 'UPDATE users SET email = :email, password = :password WHERE id = :id';
        $statement = $this->connection->prepare($updateQuery);
        $statement->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $statement->bindValue(':email', $user->getEmail());
        $statement->bindValue(':password', $hash);

        return $statement->execute();
    }

    public function removeUser(User $user): bool
    {
        $statement = $this->connection->prepare('DElETE FROM users WHERE id = ?;');
        $statement->bindValue(1, $user->getId(), PDO::PARAM_INT);

        return $statement->execute();
    }

}