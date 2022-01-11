<?php

namespace App\DataFixtures;

use App\Entity\Planets;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Technologies;
use App\Entity\User;
use App\Entity\Batiments;
use App\Entity\BatimentOwned;
use App\Entity\TechnologiesOwned;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Recycler extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $technoAttack = new Technologies();
        $technoAttack->setName("Attack")
                ->setPrice(10)
                ->setLvlMax(10)
                ->setDescription("this upgrade is use for upgrade the attack of your unites")
                ->setDamage(0)
                ->setGoldBoost(0)
                ->setDamagePerLevel(5)
                ->setGoldBoostPerLevel(0)
                ->setUpgradeTime(20);
        $manager->persist($technoAttack);

        $technoGold = new Technologies();
        $technoGold->setName("Gold boost")
                ->setPrice(40)
                ->setLvlMax(5)
                ->setDescription("this upgrade is use for upgrade the gold product by building")
                ->setDamage(0)
                ->setGoldBoost(0)
                ->setDamagePerLevel(0)
                ->setGoldBoostPerLevel(5)
                ->setUpgradeTime(10);
        $manager->persist($technoGold);

        $typeBuilding = ["damage", "unite", "gold"];
        $allBuilding = array();
        for ($i=0; $i < 10; $i++) {
            $rand = rand(0, 2);
            $build = new Batiments();
            $build->setName("build_".$typeBuilding[$rand].$i)
                ->setPrice(rand(10, 15))
                ->setLvlMax(10)
                ->setImage("https://thumbs.dreamstime.com/b/buildings-line-icon-city-architecture-sign-skyscraper-building-vector-buildings-line-icon-city-architecture-sign-skyscraper-148085776.jpg")
                ->setDamage($typeBuilding[$rand] == "damage" ? rand(100, 200) : 0)
                ->setLevel(0)
                ->setHp(rand(500, 900))
                ->setDamagePerLvl($typeBuilding[$rand] == "damage" ? rand(20, 50) : 0)
                ->setGoldPerHour($typeBuilding[$rand] == "gold" ? rand(10, 50) : 0)
                ->setHpPerLvl(rand(100, 300))
                ->setGoldPerHourPerLvl($typeBuilding[$rand] == "damage" ? rand(100, 200) : 0)
                ->setUnitesPerHourPerLvl($typeBuilding[$rand] == "unite" ? rand(60, 200) : 0)
                ->setUnitesPerHour($typeBuilding[$rand] == "unite" ? rand(60, 200) : 0)
                ->setUpgradeTime(rand(10, 100));
            $allBuilding[] = $build;
            $manager->persist($build);
        }

        $allUser = array();
        for ($i=0; $i < 10; $i++) {
            $technologiesOwnedAttack = new technologiesOwned();
            $technologiesOwnedAttack->setType($technoAttack)
                                    ->setLevel(0)
                                    ->setStartupgrade(null)
                                    ->setEndupgrade(null)
                                    ->setUpgrading(false);
            $manager->persist($technologiesOwnedAttack);

            $technologiesOwnedGold = new technologiesOwned();
            $technologiesOwnedGold->setType($technoGold)
                                ->setLevel(0)
                                ->setStartupgrade(null)
                                ->setEndupgrade(null)
                                ->setUpgrading(false);
            $manager->persist($technologiesOwnedGold);

            $user = new User();
            $hash = $this->encoder->encodePassword($user, '1234');
            $user->setUsername('name'.$i.'@m')
                ->setPassword($hash)
                ->setGold(rand(20, 100))
                ->setElo(rand(500, 2000))
                ->setUnits(rand(10, 100))
                ->setImage("https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg")
                ->addUserTechnoOwned($technologiesOwnedAttack)
                ->addUserTechnoOwned($technologiesOwnedGold)
                ->setlastUpdate(new \DateTime('now'));

            for ($j=0; $j < rand(2, 7); $j++) {
                $userBuildingOwned = $allBuilding[rand(0, 9)];
                $buildingOwned = new BatimentOwned();
                $buildingOwned->setType($userBuildingOwned)
                            ->setHp($userBuildingOwned->getHp())
                            ->setLevel(0)
                            ->setStartupgrade(null)
                            ->setEndupgrade(null)
                            ->setUpgrading(false);
                $manager->persist($buildingOwned);

                $user->addBatimentsOwned($buildingOwned);
            }
            $allUser[] =$user;
            $manager->persist($user);
        }

        $allPlanet = array();
        $planetId = ['Mercure', 'Venus', 'Terre', 'Mars', 'Jupiter', 'Saturne', 'Uranus', 'Neptune'];
        for ($i=0; $i < count($planetId); $i++) {
            $planet = new Planets();
            $planet->setName($planetId[$i])
                ->setDefenseLvl(rand(1, 5))
                ->setDistance(($i + 1) * rand(1000, 2000))
                ->setImage('https://live.staticflickr.com/197/447182941_dc272887ee_m.jpg');
            $allPlanet[] = $planet;
        }

        $countUser = 0;
        $countPlanet = 0;
        $loopNumber = (count($allUser) > count($allPlanet)) ? count($allUser) : count($allPlanet);
        for ($i=0; $i < $loopNumber; $i++) {
            $allPlanet[$countPlanet]->addPlayer($allUser[$countUser]);
            $countUser = ($countUser + 1 == count($allUser)) ? 0 : $countUser + 1;
            $countPlanet = ($countPlanet + 1 == count($allPlanet)) ? 0 : $countPlanet + 1;
        }

        for ($i=0; $i < count($allPlanet); $i++) {
            $manager->persist($allPlanet[$i]);
        }
        $manager->flush();
    }
}
