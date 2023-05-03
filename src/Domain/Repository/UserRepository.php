<?php

namespace Yago\Aluraplay\Domain\Repository;

use Yago\Aluraplay\Domain\Model\User;

interface UserRepository
{
    public function allUsers(): array;
    public function userForId(User $user): User;
    public function saveUser(User $user): bool;
    public function removeUser(User $user): bool;
}