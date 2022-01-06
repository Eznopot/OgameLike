<?php

namespace App\Entity;

use App\Repository\TechnologiesOwnedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnologiesOwnedRepository::class)]
class TechnologiesOwned
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $level;

    #[ORM\ManyToOne(targetEntity: Technologies::class)]
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

    public function getType(): ?Technologies
    {
        return $this->type;
    }

    public function setType(?Technologies $type): self
    {
        $this->type = $type;

        return $this;
    }
}
