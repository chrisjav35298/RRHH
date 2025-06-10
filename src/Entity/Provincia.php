<?php

namespace App\Entity;

use App\Repository\ProvinciaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProvinciaRepository::class)]
class Provincia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\ManyToOne(inversedBy: 'provincias')]
    private ?Pais $pais = null;

    /**
     * @var Collection<int, Ubicacion>
     */
    #[ORM\OneToMany(targetEntity: Ubicacion::class, mappedBy: 'provincia')]
    private Collection $ubicacions;

    public function __construct()
    {
        $this->ubicacions = new ArrayCollection();
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

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPais(): ?Pais
    {
        return $this->pais;
    }

    public function setPais(?Pais $pais): static
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * @return Collection<int, Ubicacion>
     */
    public function getUbicacions(): Collection
    {
        return $this->ubicacions;
    }

    public function addUbicacion(Ubicacion $ubicacion): static
    {
        if (!$this->ubicacions->contains($ubicacion)) {
            $this->ubicacions->add($ubicacion);
            $ubicacion->setProvincia($this);
        }

        return $this;
    }

    public function removeUbicacion(Ubicacion $ubicacion): static
    {
        if ($this->ubicacions->removeElement($ubicacion)) {
            // set the owning side to null (unless already changed)
            if ($ubicacion->getProvincia() === $this) {
                $ubicacion->setProvincia(null);
            }
        }

        return $this;
    }
}
