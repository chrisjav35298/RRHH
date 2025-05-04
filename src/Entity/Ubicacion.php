<?php

namespace App\Entity;

use App\Repository\UbicacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UbicacionRepository::class)]
class Ubicacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $calle = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $codigoPostal = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ciudad = null;

    #[ORM\ManyToOne(inversedBy: 'ubicacions')]
    private ?Provincia $provincia = null;

    /**
     * @var Collection<int, Departamento>
     */
    #[ORM\OneToMany(targetEntity: Departamento::class, mappedBy: 'ubicacion')]
    private Collection $departamentos;

    public function __construct()
    {
        $this->departamentos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(?string $calle): static
    {
        $this->calle = $calle;

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(?string $codigoPostal): static
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(?string $ciudad): static
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getProvincia(): ?Provincia
    {
        return $this->provincia;
    }

    public function setProvincia(?Provincia $provincia): static
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * @return Collection<int, Departamento>
     */
    public function getDepartamentos(): Collection
    {
        return $this->departamentos;
    }

    public function addDepartamento(Departamento $departamento): static
    {
        if (!$this->departamentos->contains($departamento)) {
            $this->departamentos->add($departamento);
            $departamento->setUbicacion($this);
        }

        return $this;
    }

    public function removeDepartamento(Departamento $departamento): static
    {
        if ($this->departamentos->removeElement($departamento)) {
            // set the owning side to null (unless already changed)
            if ($departamento->getUbicacion() === $this) {
                $departamento->setUbicacion(null);
            }
        }

        return $this;
    }
}
