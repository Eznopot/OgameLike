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

    #[ORM\Column(type: 'integer')]
    private $start;

    #[ORM\Column(type: 'integer')]
    private $difficuly;

    #[ORM\Column(type: 'integer')]
    private $endTime;

    #[ORM\OneToOne(inversedBy: 'ongoingAtk', targetEntity: Planets::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $planetID;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'ongoingAtks')]
    private $playerID;

    public function __construct()
    {
        $this->playerID = new ArrayCollection();
    }

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

    public function getEndTime(): ?int
    {
        return $this->endTime;
    }

    public function setEndTime(int $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getPlanetID(): ?Planets
    {
        return $this->planetID;
    }

    public function setPlanetID(Planets $planetID): self
    {
        $this->planetID = $planetID;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getPlayerID(): Collection
    {
        return $this->playerID;
    }

    public function addPlayerID(User $playerID): self
    {
        if (!$this->playerID->contains($playerID)) {
            $this->playerID[] = $playerID;
        }

        return $this;
    }

    public function removePlayerID(User $playerID): self
    {
        $this->playerID->removeElement($playerID);

        return $this;
    }
}
