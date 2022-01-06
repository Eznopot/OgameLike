<?php

namespace App\Services;

use Symfony\Component\Form\Form;
use App\Entity\User;
use Symfony\Component\Form\Exception\ExceptionInterface;

use Doctrine\Persistence\ManagerRegistry;

class LoginServices
{
    public function __construct()
    {
    }

    /**
     * @param Form $form
     */
    public function loginRequest(
        Form $form,
        ManagerRegistry $doctrine
    ): int {
        $user = $doctrine->getRepository(User::class)->findOneBy(['username' => $form->get('Email')->getData(),
                                                                'password' => $form->get('Password')->getData()]);
        if (!$user) {
            return 1;
        }
        return 0;
    }
}