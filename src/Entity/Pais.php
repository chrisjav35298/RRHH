<?php

namespace App\Entity;

use App\Repository\PaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaisRepository::class)]
class Pais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Provincia>
     */
    #[ORM\OneToMany(targetEntity: Provincia::class, mappedBy: 'pais', cascade:['persist','remove'],orphanRemoval: true)]
    private Collection $provincias;

    public function __construct()
    {
        $this->provincias = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Provincia>
     */
    public function getProvincias(): Collection
    {
        return $this->provincias;
    }

    public function addProvincia(Provincia $provincia): static
    {
        if (!$this->provincias->contains($provincia)) {
            $this->provincias->add($provincia);
            $provincia->setPais($this);
        }

        return $this;
    }

    public function removeProvincia(Provincia $provincia): static
    {
        if ($this->provincias->removeElement($provincia)) {
            // set the owning side to null (unless already changed)
            if ($provincia->getPais() === $this) {
                $provincia->setPais(null);
            }
        }

        return $this;
    }
}
