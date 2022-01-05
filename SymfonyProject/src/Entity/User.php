<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'integer')]
    private $gold;

    #[ORM\Column(type: 'integer')]
    private $elo;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $image;

    #[ORM\ManyToMany(targetEntity: BatimentOwned::class)]
    private $batimentsOwned;

    #[ORM\ManyToMany(targetEntity: UnitsOwned::class)]
    private $unitsOwned;

    public function __construct()
    {
        $this->batimentsOwned = new ArrayCollection();
        $this->unitsOwned = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getGold(): ?int
    {
        return $this->gold;
    }

    public function setGold(int $gold): self
    {
        $this->gold = $gold;

        return $this;
    }

    public function getElo(): ?int
    {
        return $this->elo;
    }

    public function setElo(int $elo): self
    {
        $this->elo = $elo;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|BatimentOwned[]
     */
    public function getBatimentsOwned(): Collection
    {
        return $this->batimentsOwned;
    }

    public function addBatimentsOwned(BatimentOwned $batimentsOwned): self
    {
        if (!$this->batimentsOwned->contains($batimentsOwned)) {
            $this->batimentsOwned[] = $batimentsOwned;
        }

        return $this;
    }

    public function removeBatimentsOwned(BatimentOwned $batimentsOwned): self
    {
        $this->batimentsOwned->removeElement($batimentsOwned);

        return $this;
    }

    /**
     * @return Collection|UnitsOwned[]
     */
    public function getUnitsOwned(): Collection
    {
        return $this->unitsOwned;
    }

    public function addUnitsOwned(UnitsOwned $unitsOwned): self
    {
        if (!$this->unitsOwned->contains($unitsOwned)) {
            $this->unitsOwned[] = $unitsOwned;
        }

        return $this;
    }

    public function removeUnitsOwned(UnitsOwned $unitsOwned): self
    {
        $this->unitsOwned->removeElement($unitsOwned);

        return $this;
    }
}
