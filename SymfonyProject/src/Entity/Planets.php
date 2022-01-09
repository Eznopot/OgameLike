<?php

namespace App\Entity;

use App\Repository\PlanetsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToOne(mappedBy: 'planetID', targetEntity: OngoingAtk::class, cascade: ['persist', 'remove'])]
    private $ongoingAtk;

    #[ORM\OneToMany(mappedBy: 'planet', targetEntity: User::class)]
    private $Players;

    public function __construct()
    {
        $this->Players = new ArrayCollection();
    }

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

    public function isUnderAtk(): ?bool
    {
        if($this->getOngoingAtk() != null)
            return true;
        return false;
    }

    public function getOngoingAtk(): ?OngoingAtk
    {
        return $this->ongoingAtk;
    }

    public function setOngoingAtk(OngoingAtk $ongoingAtk): self
    {
        // set the owning side of the relation if necessary
        if ($ongoingAtk->getPlanetID() !== $this) {
            $ongoingAtk->setPlanetID($this);
        }

        $this->ongoingAtk = $ongoingAtk;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getPlayers(): Collection
    {
        return $this->Players;
    }

    public function addPlayer(User $player): self
    {
        if (!$this->Players->contains($player)) {
            $this->Players[] = $player;
            $player->setPlanet($this);
        }

        return $this;
    }

    public function removePlayer(User $player): self
    {
        if ($this->Players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getPlanet() === $this) {
                $player->setPlanet(null);
            }
        }

        return $this;
    }
}
