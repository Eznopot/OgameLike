<?php

namespace App\Controller;

use App\Form\RegisterFormType;
use App\Services\RegisterServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\ExceptionInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

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
    public function register(Request $request, ManagerRegistry $doctrine): Response
    {
        /** @var Form $form */
        $form = $this->createForm(RegisterFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if ($form->getClickedButton() === $form->get('confirmer')) {
                try {
                    $res = $this->registerService->registerRequest($form, $doctrine);
                    if ($res === 0) {
                        $this->addFlash("success", "Registered");
                        return $this->redirectToRoute('connexion_login');
                    } else {
                        $this->addFlash("Error", "Already Exist");
                    }
                    
                } catch (ExceptionInterface $exception) {
                    $this->addFlash("error", $exception->getMessage());
                }
            }
        }

        return $this->render('register/index.html.twig', array(
            "createRegisterForm" => $form->createView(),
        ));
    }
}
