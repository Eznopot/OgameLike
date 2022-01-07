<?php

namespace App\DataFixtures;

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
    public function load(ObjectManager $manager, UserPasswordEncoderInterface $encoder): void
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
                ->setUpgradeTime(10);
        $manager->persist($technoAttack);

        $technoGold = new Technologies();
        $technoGold->setName("Gold boost")
                ->setPrice(40)
                ->setLvlMax(5)
                ->setDescription("this upgrade is use for upgrade the gold product by building")
                ->setDamage(0)
                ->setGoldBoost(0)
                ->setDamagePerLevel(0)
                ->setGoldBoostPerLevel(10)
                ->setUpgradeTime(10);
        $manager->persist($technoGold);

        $type = ["damage", "unite", "gold"];
        for ($i=0; $i < 10; $i++) {
            $rand = rand(0, 2);
            $build = new Batiments();
            $build->setName("build_".$type[$rand].$i)
                ->setPrice(rand(10, 15))
                ->setLvlMax(10)
                ->setImage("https://thumbs.dreamstime.com/b/buildings-line-icon-city-architecture-sign-skyscraper-building-vector-buildings-line-icon-city-architecture-sign-skyscraper-148085776.jpg")

                ->setDamage($type[$rand] == "damage" ? rand(100, 200) : 0)
                ->setLevel(0)
                ->setHp(rand(500, 900))

                ->setDamagePerLvl($type[$rand] == "damage" ? rand(20, 50) : 0)
                ->setGoldPerHour($type[$rand] == "gold" ? rand(10, 50) : 0)
                ->setHpPerLvl(rand(100, 300))

                ->setGoldPerHourPerLvl($type[$rand] == "damage" ? rand(100, 200) : 0);
            $manager->persist($build);    
        }

        // $buildingOwned = new BatimentOwned();
        // for ($i=0; $i < 5; $i++) {

        // }


        for ($i=0; $i < 4; $i++) {
            $technologiesOwned = new technologiesOwned();

            

            $user = new User();

            $hash = $encoder->encodePassword($user, '1234');
            $user->setUsername('user_num_'.$i)
                ->setPassword($hash)
                ->setGold(0)
                ->setElo(0)
                ->setImage("https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg");

            $manager->persist($user);
        }

        $manager->flush();
    }
}
