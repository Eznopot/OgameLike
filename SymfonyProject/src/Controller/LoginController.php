<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Services\LoginServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
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

    /**
     * @Route("/login", name="connexion_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        /** @var Form $form */
        $form = $this->createForm(LoginFormType::class);


        if($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirmer')) {
                try {
                    $this->loginService->loginRequest($form);
                    $this->addFlash("success", "Logged in");
                    return $this->redirectToRoute("");
                } catch (TransportExceptionInterface $exception) {
                    $this->addFlash("error", $exception->getMessage());
                }
            }
        }

        return $this->render('login/index.html.twig', array(
            "createLoginForm" => $form->createView()
        ));
    }
}
