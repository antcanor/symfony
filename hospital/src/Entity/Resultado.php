<?php

namespace App\Entity;

use App\Repository\ResultadoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultadoRepository::class)]
class Resultado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'resultados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Respuesta $respuesta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRespuesta(): ?Respuesta
    {
        return $this->respuesta;
    }

    public function setRespuesta(?Respuesta $respuesta): static
    {
        $this->respuesta = $respuesta;

        return $this;
    }
}
