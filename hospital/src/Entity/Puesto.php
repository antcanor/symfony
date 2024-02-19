<?php

namespace App\Entity;

use App\Repository\PuestoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PuestoRepository::class)]
class Puesto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fin = null;

    #[ORM\OneToMany(targetEntity: Bolsa::class, mappedBy: 'puesto')]
    private Collection $bolsas;

    public function __construct()
    {
        $this->bolsas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): static
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * @return Collection<int, Bolsa>
     */
    public function getBolsas(): Collection
    {
        return $this->bolsas;
    }

    public function addBolsa(Bolsa $bolsa): static
    {
        if (!$this->bolsas->contains($bolsa)) {
            $this->bolsas->add($bolsa);
            $bolsa->setPuesto($this);
        }

        return $this;
    }

    public function removeBolsa(Bolsa $bolsa): static
    {
        if ($this->bolsas->removeElement($bolsa)) {
            // set the owning side to null (unless already changed)
            if ($bolsa->getPuesto() === $this) {
                $bolsa->setPuesto(null);
            }
        }

        return $this;
    }
}
