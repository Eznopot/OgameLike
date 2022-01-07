<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
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

    #[ORM\ManyToMany(targetEntity: TechnologiesOwned::class)]
    private $userTechnoOwned;

    #[ORM\Column(type: 'integer')]
    private $units;

    public function __construct()
    {
        $this->batimentsOwned = new ArrayCollection();
        $this->userTechnoOwned = new ArrayCollection();
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
     * @return Collection|TechnologiesOwned[]
     */
    public function getUserTechnoOwned(): Collection
    {
        return $this->userTechnoOwned;
    }

    public function addUserTechnoOwned(TechnologiesOwned $userTechnoOwned): self
    {
        if (!$this->userTechnoOwned->contains($userTechnoOwned)) {
            $this->userTechnoOwned[] = $userTechnoOwned;
        }

        return $this;
    }

    public function removeUserTechnoOwned(TechnologiesOwned $userTechnoOwned): self
    {
        $this->userTechnoOwned->removeElement($userTechnoOwned);

        return $this;
    }

    public function eraseCredentials() {}
    public function getSalt() {}
    public function getRoles() {
        return ["ROLE_USER"];
    }

    public function getUnits(): ?int
    {
        return $this->units;
    }

    public function setUnits(int $units): self
    {
        $this->units = $units;

        return $this;
    }
}
