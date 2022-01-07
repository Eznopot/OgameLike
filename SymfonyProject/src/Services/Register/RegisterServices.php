<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Form\Exception\ExceptionInterface;
use Symfony\Component\Form\Form;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
            //$user->setPassword($form->get('Password')->getData());
            $hash = $encoder->encodePassword($user, $form->get('Password')->getData());
            print_r($hash);
            $user->setPassword($hash);
            $user->setGold(0);
            $user->setUnits(0);
            $user->setElo(0);
            $entityManager->persist($user);
            $entityManager->flush();
            return 0;
        }
    }
}