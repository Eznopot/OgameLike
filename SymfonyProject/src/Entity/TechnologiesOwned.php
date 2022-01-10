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

    #[ORM\Column(type: 'boolean')]
    private $upgrading;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $startupgrade;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $endupgrade;

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

    public function setUpgrading(bool $upgrading): self
    {
        $this->upgrading = $upgrading;

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
}
