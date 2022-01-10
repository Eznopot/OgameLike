<?php

namespace App\Entity;

use App\Repository\OngoingAtkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OngoingAtkRepository::class)]
class OngoingAtk
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $start;

    #[ORM\Column(type: 'integer')]
    private $difficuly;

    #[ORM\Column(type: 'datetime')]
    private $endTime;

    #[ORM\Column(type: 'integer')]
    private $SuccessRate;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $UnitsAtk;

    #[ORM\ManyToOne(targetEntity: Planets::class, inversedBy: 'ongoingAtk')]
    #[ORM\JoinColumn(nullable: false)]
    private $planets;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ongoingAtks')]
    #[ORM\JoinColumn(nullable: false)]
    private $playerID;

    public function __construct()
    {
        $this->playerID = new ArrayCollection();
        $this->planets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getDifficuly(): ?int
    {
        return $this->difficuly;
    }

    public function setDifficuly(int $difficuly): self
    {
        $this->difficuly = $difficuly;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getSuccessRate(): ?int
    {
        return $this->SuccessRate;
    }

    public function setSuccessRate(int $SuccessRate): self
    {
        $this->SuccessRate = $SuccessRate;

        return $this;
    }

    public function getUnitsAtk(): ?int
    {
        return $this->UnitsAtk;
    }

    public function setUnitsAtk(?int $UnitsAtk): self
    {
        $this->UnitsAtk = $UnitsAtk;

        return $this;
    }

    public function getPlanets(): ?Planets
    {
        return $this->planets;
    }

    public function setPlanets(?Planets $planets): self
    {
        $this->planets = $planets;

        return $this;
    }

    public function getPlayerID(): ?User
    {
        return $this->playerID;
    }

    public function setPlayerID(?User $playerID): self
    {
        $this->playerID = $playerID;

        return $this;
    }
}
