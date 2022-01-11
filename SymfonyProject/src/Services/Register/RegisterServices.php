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
            $user->setGold(400);
            $user->setUnits(150);
            $user->setElo(1000);
            $user->setPlanet($doctrine->getRepository(Planets::class)->find($form->get('Planet')->getData()));
            $user->setLastUpdate(new \DateTime());

            $techno = $doctrine->getRepository(Planets::class)->findAll();

            for ($i=0; $i < $techno->count(); $i++) {
                $technologiesOwned = new technologiesOwned();
                $technologiesOwned->setType($technologiesOwned)
                            ->setLevel(0)
                            ->setStartupgrade(null)
                            ->setEndupgrade(null)
                            ->setUpgrading(false);
                $user->addUserTechnoOwned($technologiesOwned);
                $entityManager->persist($technologiesOwned);
            }

            $entityManager->persist($user);
            $entityManager->flush();
            return 0;
        }
    }
}