<?php

namespace App\Entity;

use App\Repository\BatimentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BatimentsRepository::class)]
class Batiments
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

    #[ORM\Column(type: 'integer')]
    private $goldPerHour;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'integer')]
    private $damage;

    #[ORM\Column(type: 'integer')]
    private $level;

    #[ORM\Column(type: 'integer')]
    private $hp;

    #[ORM\Column(type: 'integer')]
    private $damagePerLvl;

    #[ORM\Column(type: 'integer')]
    private $goldPerHourPerLvl;

    #[ORM\Column(type: 'integer')]
    private $hpPerLvl;

    #[ORM\Column(type: 'integer')]
    private $UpgradeTime;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $unitesPerHourPerLvl;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $unitesPerHour;

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

    public function getGoldPerHour(): ?int
    {
        return $this->goldPerHour;
    }

    public function setGoldPerHour(int $goldPerHour): self
    {
        $this->goldPerHour = $goldPerHour;

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

    public function getDamage(): ?int
    {
        return $this->damage;
    }

    public function setDamage(int $damage): self
    {
        $this->damage = $damage;

        return $this;
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

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getDamagePerLvl(): ?int
    {
        return $this->damagePerLvl;
    }

    public function setDamagePerLvl(int $damagePerLvl): self
    {
        $this->damagePerLvl = $damagePerLvl;

        return $this;
    }

    public function getGoldPerHourPerLvl(): ?int
    {
        return $this->goldPerHourPerLvl;
    }

    public function setGoldPerHourPerLvl(int $goldPerHourPerLvl): self
    {
        $this->goldPerHourPerLvl = $goldPerHourPerLvl;

        return $this;
    }

    public function getHpPerLvl(): ?int
    {
        return $this->hpPerLvl;
    }

    public function setHpPerLvl(int $hpPerLvl): self
    {
        $this->hpPerLvl = $hpPerLvl;

        return $this;
    }

    public function getUpgradeTime(): ?int
    {
        return $this->UpgradeTime;
    }

    public function setUpgradeTime(int $UpgradeTime): self
    {
        $this->UpgradeTime = $UpgradeTime;

        return $this;
    }

    public function getUnitesPerHourPerLvl(): ?int
    {
        return $this->unitesPerHourPerLvl;
    }

    public function setUnitesPerHourPerLvl(?int $unitesPerHourPerLvl): self
    {
        $this->unitesPerHourPerLvl = $unitesPerHourPerLvl;

        return $this;
    }

    public function getUnitesPerHour(): ?int
    {
        return $this->unitesPerHour;
    }

    public function setUnitesPerHour(?int $unitesPerHour): self
    {
        $this->unitesPerHour = $unitesPerHour;

        return $this;
    }
}
