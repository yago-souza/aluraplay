<?php

namespace Yago\Aluraplay\Domain\Model;

class Video
{
    private ?int $id;
    private string $titulo;
    private string $url;

    public function __construct(?int $id, string $titulo, string $url)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->url = $url;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new \DomainException('Você só pode definir o ID uma vez');
        }
        $this->id = $id;
    }

    public function setTitulo(string $newTitulo): void
    {
        $this->titulo = $newTitulo;
    }

    public function setUrl(string $newUrl): void
    {
        $this->url = $newUrl;
    }
}
