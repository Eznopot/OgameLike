<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Form\Exception\ExceptionInterface;
use Symfony\Component\Form\Form;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Planets;

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
            $user->setGold(0);
            $user->setUnits(0);
            $user->setElo(1000);
            $user->setPlanet($doctrine->getRepository(Planets::class)->findOneBy(['id' => $form->get('Planet')->getData()]));
            $user->setLastUpdate(new \DateTime());
            $entityManager->persist($user);
            $entityManager->flush();
            return 0;
        }
    }
}