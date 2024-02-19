<?php

namespace App\Entity;

use App\Repository\MedicoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedicoRepository::class)]
class Medico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $nombre = null;

    #[ORM\ManyToMany(targetEntity: Especialidad::class, inversedBy: 'medicos')]
    private Collection $especialidad;

    public function __construct()
    {
        $this->especialidad = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Especialidad>
     */
    public function getEspecialidad(): Collection
    {
        return $this->especialidad;
    }

    public function addEspecialidad(Especialidad $especialidad): static
    {
        if (!$this->especialidad->contains($especialidad)) {
            $this->especialidad->add($especialidad);
        }

        return $this;
    }

    public function removeEspecialidad(Especialidad $especialidad): static
    {
        $this->especialidad->removeElement($especialidad);

        return $this;
    }
}
