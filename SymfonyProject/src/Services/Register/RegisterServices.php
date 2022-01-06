<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Form\Exception\ExceptionInterface;
use Symfony\Component\Form\Form;
use Doctrine\Persistence\ManagerRegistry;

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
        ManagerRegistry $doctrine
    ): int {
        $entityManager = $doctrine->getManager();
        $check = $doctrine->getRepository(User::class)->findOneBy(['username' => $form->get('Email')->getData()]);
        if ($check) {
            return 1;
        } else {
            $user = new User();
            $user->setUsername($form->get('Email')->getData());
            $user->setPassword($form->get('Password')->getData());
            $user->setGold(0);
            $user->setElo(0);
            $entityManager->persist($user);
            $entityManager->flush();
            return 0;
        }
    }
}