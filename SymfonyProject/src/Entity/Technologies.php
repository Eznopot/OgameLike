<?php

namespace App\Entity;

use App\Repository\TechnologiesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnologiesRepository::class)]
class Technologies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'integer')]
    private $lvlMax;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Description;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $damage;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $goldBoost;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $DamagePerLevel;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $goldBoostPerLevel;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getLvlMax(): ?int
    {
        return $this->lvlMax;
    }

    public function setLvlMax(int $lvlMax): self
    {
        $this->lvlMax = $lvlMax;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(?int $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getGoldBoost(): ?int
    {
        return $this->goldBoost;
    }

    public function setGoldBoost(?int $goldBoost): self
    {
        $this->goldBoost = $goldBoost;

        return $this;
    }

    public function getDamagePerLevel(): ?int
    {
        return $this->DamagePerLevel;
    }

    public function setDamagePerLevel(?int $DamagePerLevel): self
    {
        $this->DamagePerLevel = $DamagePerLevel;

        return $this;
    }

    public function getGoldBoostPerLevel(): ?int
    {
        return $this->goldBoostPerLevel;
    }

    public function setGoldBoostPerLevel(?int $goldBoostPerLevel): self
    {
        $this->goldBoostPerLevel = $goldBoostPerLevel;

        return $this;
    }
}
