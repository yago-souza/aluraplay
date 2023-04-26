<?php

namespace Alura\Domain\Repository;

use Alura\Domain\Model\Video;

interface VideoRepository
{
    public function allVideos(): array;
    public function saveVideo(Video $video): bool;
    public function remove(Video $video): bool;
}