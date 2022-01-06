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

    /**
     * @Route("/login", name="connexion_login")
     */
    public function login(Request $request, ManagerRegistry $doctrine): Response
    {
        /** @var Form $form */
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirmer')) {
                try {
                    $result = $this->loginService->loginRequest($form, $doctrine);
                    if ($result === 0) {
                        $this->addFlash("success", "Logged in");
                        return $this->redirectToRoute("home");
                    } else {
                        $this->addFlash("Error", "Not Exist");
                    }
                } catch (ExceptionInterface $exception) {
                    $this->addFlash("error", $exception->getMessage());
                }
            }
        }

        return $this->render('login/index.html.twig', array(
            "createLoginForm" => $form->createView()
        ));
    }
}
