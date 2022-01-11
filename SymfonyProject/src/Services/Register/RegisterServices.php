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
            dump($form->get('Planet'));

            $planetChoose = $doctrine->getRepository(Planets::class)->find($form->get('Planet'));

            dump($planetChoose);

            $user = new User();
            $user->setUsername($form->get('Email')->getData());
            $hash = $encoder->encodePassword($user, $form->get('Password')->getData());

            $user->setPassword($hash)
                ->setGold(400)
                ->setUnits(150)
                ->setElo(1000)
                ->setPlanet()
                ->setLastUpdate(new \DateTime());

            $techno = $doctrine->getRepository(Planets::class)->findAll();

            for ($i=0; $i < count($techno); $i++) {
                $technologiesOwned = new technologiesOwned();
                $technologiesOwned->setType($techno[$i])
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