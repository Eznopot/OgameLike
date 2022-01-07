<?php

namespace App\Entity;

use App\Repository\OngoingAtkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OngoingAtkRepository::class)]
class OngoingAtk
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $start;

    #[ORM\Column(type: 'integer')]
    private $difficuly;

    #[ORM\Column(type: 'integer')]
    private $numberOfUnits;

    #[ORM\Column(type: 'integer')]
    private $timeOfAtk;

    #[ORM\Column(type: 'integer')]
    private $planetID;

    #[ORM\Column(type: 'integer')]
    private $playerID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?int
    {
        return $this->start;
    }

    public function setStart(int $start): self
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

    public function getNumberOfUnits(): ?int
    {
        return $this->numberOfUnits;
    }

    public function setNumberOfUnits(int $numberOfUnits): self
    {
        $this->numberOfUnits = $numberOfUnits;

        return $this;
    }

    public function getTimeOfAtk(): ?int
    {
        return $this->timeOfAtk;
    }

    public function setTimeOfAtk(int $timeOfAtk): self
    {
        $this->timeOfAtk = $timeOfAtk;

        return $this;
    }

    public function getPlanetID(): ?int
    {
        return $this->planetID;
    }

    public function setPlanetID(int $planetID): self
    {
        $this->planetID = $planetID;

        return $this;
    }

    public function getPlayerID(): ?int
    {
        return $this->playerID;
    }

    public function setPlayerID(int $playerID): self
    {
        $this->playerID = $playerID;

        return $this;
    }
}
