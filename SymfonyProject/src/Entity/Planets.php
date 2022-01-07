<?php

namespace App\Entity;

use App\Repository\PlanetsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanetsRepository::class)]
class Planets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $defenseLvl;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $distance;

    #[ORM\Column(type: 'boolean')]
    private $underAtk;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDefenseLvl(): ?int
    {
        return $this->defenseLvl;
    }

    public function setDefenseLvl(?int $defenseLvl): self
    {
        $this->defenseLvl = $defenseLvl;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(?int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getUnderAtk(): ?bool
    {
        return $this->underAtk;
    }

    public function setUnderAtk(bool $underAtk): self
    {
        $this->underAtk = $underAtk;

        return $this;
    }
}
