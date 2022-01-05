<?php

namespace App\Entity;

use App\Repository\BatimentOwnedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BatimentOwnedRepository::class)]
class BatimentOwned
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $level;

    #[ORM\ManyToOne(targetEntity: Batiments::class)]
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

    public function getType(): ?Batiments
    {
        return $this->type;
    }

    public function setType(?Batiments $type): self
    {
        $this->type = $type;

        return $this;
    }
}
