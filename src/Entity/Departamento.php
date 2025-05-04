<?php

namespace App\Entity;

use App\Repository\DepartamentoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartamentoRepository::class)]
class Departamento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nombre = null;

    #[ORM\ManyToOne(inversedBy: 'departamentos')]
    private ?Ubicacion $ubicacion = null;

    /**
     * @var Collection<int, Empleado>
     */
    #[ORM\OneToMany(targetEntity: Empleado::class, mappedBy: 'departamento')]
    private Collection $empleados;

    /**
     * @var Collection<int, HistorialPuesto>
     */
    #[ORM\OneToMany(targetEntity: HistorialPuesto::class, mappedBy: 'departamento')]
    private Collection $historialPuestos;

    #[ORM\ManyToOne(inversedBy: 'departamentos')]
    private ?Empleado $jefe = null;

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

    public function getUbicacion(): ?Ubicacion
    {
        return $this->ubicacion;
    }

    public function setUbicacion(?Ubicacion $ubicacion): static
    {
        $this->ubicacion = $ubicacion;

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
            $empleado->setDepartamento($this);
        }

        return $this;
    }

    public function removeEmpleado(Empleado $empleado): static
    {
        if ($this->empleados->removeElement($empleado)) {
            // set the owning side to null (unless already changed)
            if ($empleado->getDepartamento() === $this) {
                $empleado->setDepartamento(null);
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
            $historialPuesto->setDepartamento($this);
        }

        return $this;
    }

    public function removeHistorialPuesto(HistorialPuesto $historialPuesto): static
    {
        if ($this->historialPuestos->removeElement($historialPuesto)) {
            // set the owning side to null (unless already changed)
            if ($historialPuesto->getDepartamento() === $this) {
                $historialPuesto->setDepartamento(null);
            }
        }

        return $this;
    }

    public function getJefe(): ?Empleado
    {
        return $this->jefe;
    }

    public function setJefe(?Empleado $jefe): static
    {
        $this->jefe = $jefe;

        return $this;
    }
}
