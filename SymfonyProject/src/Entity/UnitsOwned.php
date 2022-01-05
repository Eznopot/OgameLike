<?php

namespace App\Entity;

use App\Repository\UnitsOwnedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitsOwnedRepository::class)]
class UnitsOwned
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $level;

    #[ORM\ManyToOne(targetEntity: Units::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $type;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getType(): ?Units
    {
        return $this->type;
    }

    public function setType(?Units $type): self
    {
        $this->type = $type;

        return $this;
    }
}
