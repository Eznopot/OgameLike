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

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $startupgrade;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $endupgrade;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $upgrading;

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

    public function getStartupgrade(): ?\DateTimeInterface
    {
        return $this->startupgrade;
    }

    public function setStartupgrade(?\DateTimeInterface $startupgrade): self
    {
        $this->startupgrade = $startupgrade;

        return $this;
    }

    public function getEndupgrade(): ?\DateTimeInterface
    {
        return $this->endupgrade;
    }

    public function setEndupgrade(?\DateTimeInterface $endupgrade): self
    {
        $this->endupgrade = $endupgrade;

        return $this;
    }

    public function getUpgrading(): ?bool
    {
        return $this->upgrading;
    }

    public function setUpgrading(?bool $upgrading): self
    {
        $this->upgrading = $upgrading;

        return $this;
    }
}
