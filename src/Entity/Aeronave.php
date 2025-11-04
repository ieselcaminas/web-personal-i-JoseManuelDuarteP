<?php

namespace App\Entity;

use App\Repository\AeronaveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AeronaveRepository::class)]
class Aeronave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $modelo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha_construccion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $apodo = null;

    #[ORM\ManyToOne(inversedBy: 'aeronave')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Propietario $propietario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): static
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getFechaConstruccion(): ?\DateTime
    {
        return $this->fecha_construccion;
    }

    public function setFechaConstruccion(\DateTime $fecha_construccion): static
    {
        $this->fecha_construccion = $fecha_construccion;

        return $this;
    }

    public function getApodo(): ?string
    {
        return $this->apodo;
    }

    public function setApodo(?string $apodo): static
    {
        $this->apodo = $apodo;

        return $this;
    }

    public function getPropietario(): ?Propietario
    {
        return $this->propietario;
    }

    public function setPropietario(?Propietario $propietario): static
    {
        $this->propietario = $propietario;

        return $this;
    }

    public function getFechaFormateada(): ?string
    {
        return $this->fecha_construccion ? $this->fecha_construccion->format('d/m/Y') : null;
    }
}
