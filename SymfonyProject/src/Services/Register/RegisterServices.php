<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Form\Exception\ExceptionInterface;
use Symfony\Component\Form\Form;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Planets;
use App\Entity\Technologies;
use App\Entity\Batiments;
use App\Entity\TechnologiesOwned;

class RegisterServices
{
    public function __construct()
    {
    }

    /**
     * @param Form $form
     */
    public function registerRequest(
        Form $form,
        ManagerRegistry $doctrine,
        UserPasswordEncoderInterface $encoder
    ): int {
        $entityManager = $doctrine->getManager();
        $check = $doctrine->getRepository(User::class)->findOneBy(['username' => $form->get('Email')->getData()]);
        if ($check) {
            return 1;
        } else {
            $user = new User();
            $user->setUsername($form->get('Email')->getData());
            $hash = $encoder->encodePassword($user, $form->get('Password')->getData());
            $user->setPassword($hash);
            $user->setGold(50);
            $user->setUnits(10);
            $user->setElo(1000);
            $user->setPlanet($doctrine->getRepository(Planets::class)->findOneBy(['id' => $form->get('Planet')->getData()]));
            $user->setLastUpdate(new \DateTime());

            $technoAttack = new Technologies();
            $technoAttack->setName("Attack")
                    ->setPrice(10)
                    ->setLvlMax(10)
                    ->setDescription("this upgrade is use for upgrade the attack of your unites and your buildings")
                    ->setDamage(0)
                    ->setGoldBoost(0)
                    ->setDamagePerLevel(5)
                    ->setGoldBoostPerLevel(0)
                    ->setUpgradeTime(20);
            $entityManager->persist($technoAttack);

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
            $entityManager->persist($technoGold);

            $technologiesOwnedAttack = new technologiesOwned();
            $technologiesOwnedAttack->setType($technoAttack)
                                    ->setLevel(0)
                                    ->setStartupgrade(null)
                                    ->setEndupgrade(null)
                                    ->setUpgrading(false);
            $entityManager->persist($technologiesOwnedAttack);

            $technologiesOwnedGold = new technologiesOwned();
            $technologiesOwnedGold->setType($technoGold)
                                ->setLevel(0)
                                ->setStartupgrade(null)
                                ->setEndupgrade(null)
                                ->setUpgrading(false);
            $entityManager->persist($technologiesOwnedGold);

            $user->addUserTechnoOwned($technologiesOwnedAttack);
            $user->addUserTechnoOwned($technologiesOwnedGold);
            $entityManager->persist($user);
            $entityManager->flush();
            return 0;
        }
    }
}