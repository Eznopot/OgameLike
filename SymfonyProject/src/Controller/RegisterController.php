<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Services\RegisterServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\ExceptionInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/register")
 */

class RegisterController extends AbstractController
{
    /** @var RegisterServices $registerService */
    private $registerService;

    public function __construct()
    {
        $this->registerService = new RegisterServices();
    }

    /**
     * @Route("/register", name="connexion_register")
     */
    public function register(): Response
    {
        /** @var Form $form */
        $form = $this->createForm(LoginFormType::class);

        if($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirmer')) {
                try {
                    $this->registerService->registerRequest($form);
                    $this->addFlash("success", "Registered");
                } catch (ExceptionInterface $exception) {
                    $this->addFlash("error", $exception->getMessage());
                }
                return $this->redirectToRoute('connexion_login');

            }
        }

        return $this->render('register/index.html.twig', array(
            "createRegisterForm" => $form->createView(),
        ));
    }
}
