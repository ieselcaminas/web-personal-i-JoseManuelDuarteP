<?php

namespace App\Entity;

use App\Repository\PropietarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropietarioRepository::class)]
class Propietario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column]
    private ?int $edad = null;

    /**
     * @var Collection<int, Aeronave>
     */
    #[ORM\OneToMany(targetEntity: Aeronave::class, mappedBy: 'propietario')]
    private Collection $aeronave;

    public function __construct()
    {
        $this->aeronave = new ArrayCollection();
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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(int $edad): static
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * @return Collection<int, Aeronave>
     */
    public function getAeronave(): Collection
    {
        return $this->aeronave;
    }

    public function addAeronave(Aeronave $aeronave): static
    {
        if (!$this->aeronave->contains($aeronave)) {
            $this->aeronave->add($aeronave);
            $aeronave->setPropietario($this);
        }

        return $this;
    }

    public function removeAeronave(Aeronave $aeronave): static
    {
        if ($this->aeronave->removeElement($aeronave)) {
            // set the owning side to null (unless already changed)
            if ($aeronave->getPropietario() === $this) {
                $aeronave->setPropietario(null);
            }
        }

        return $this;
    }
}
