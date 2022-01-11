<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Services\LoginServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\ExceptionInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/connexion")
 */

class LoginController extends AbstractController
{
    /** @var LoginServices $loginService */
    private $loginService;

    public function __construct()
    {
        $this->loginService = new LoginServices();
    }

    #[Route('/logout', name: 'connexion_logout', methods: ['GET'])]
    public function logout() {}

    /**
     * @Route("/login", name="connexion_login")
     */
    public function login(Request $request, ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('login/index.html.twig', array(
        ));
    }
}
