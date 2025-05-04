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

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 0, nullable: true)]
    private ?string $salarioMinimo = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 0, nullable: true)]
    private ?string $salarioMaximo = null;

    /**
     * @var Collection<int, Empleado>
     */
    #[ORM\OneToMany(targetEntity: Empleado::class, mappedBy: 'puesto')]
    private Collection $empleados;

    /**
     * @var Collection<int, HistorialPuesto>
     */
    #[ORM\OneToMany(targetEntity: HistorialPuesto::class, mappedBy: 'puesto')]
    private Collection $historialPuestos;

    public function __construct()
    {
        $this->empleados = new ArrayCollection();
        $this->historialPuestos = new ArrayCollection();
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

    public function getSalarioMinimo(): ?string
    {
        return $this->salarioMinimo;
    }

    public function setSalarioMinimo(?string $salarioMinimo): static
    {
        $this->salarioMinimo = $salarioMinimo;

        return $this;
    }

    public function getSalarioMaximo(): ?string
    {
        return $this->salarioMaximo;
    }

    public function setSalarioMaximo(?string $salarioMaximo): static
    {
        $this->salarioMaximo = $salarioMaximo;

        return $this;
    }

    /**
     * @return Collection<int, Empleado>
     */
    public function getEmpleados(): Collection
    {
        return $this->empleados;
    }

    public function addEmpleado(Empleado $empleado): static
    {
        if (!$this->empleados->contains($empleado)) {
            $this->empleados->add($empleado);
            $empleado->setPuesto($this);
        }

        return $this;
    }

    public function removeEmpleado(Empleado $empleado): static
    {
        if ($this->empleados->removeElement($empleado)) {
            // set the owning side to null (unless already changed)
            if ($empleado->getPuesto() === $this) {
                $empleado->setPuesto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistorialPuesto>
     */
    public function getHistorialPuestos(): Collection
    {
        return $this->historialPuestos;
    }

    public function addHistorialPuesto(HistorialPuesto $historialPuesto): static
    {
        if (!$this->historialPuestos->contains($historialPuesto)) {
            $this->historialPuestos->add($historialPuesto);
            $historialPuesto->setPuesto($this);
        }

        return $this;
    }

    public function removeHistorialPuesto(HistorialPuesto $historialPuesto): static
    {
        if ($this->historialPuestos->removeElement($historialPuesto)) {
            // set the owning side to null (unless already changed)
            if ($historialPuesto->getPuesto() === $this) {
                $historialPuesto->setPuesto(null);
            }
        }

        return $this;
    }
}
