<?php

namespace Alura\Domain\Repository;

use Yago\Aluraplay\Domain\Model\Video;

interface UserRepository
{
    public function allUsers(): array;
    public function userForId(Video $user): Video;
    public function saveUser(Video $user): bool;
    public function removeUser(Video $user): bool;
}