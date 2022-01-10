<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListAtkPageController extends AbstractController
{
   /**
    * @Route("/game/atklist", name="list_atk_page")
    */

    public function index(): Response
    {
        return $this->render('game/atklist.twig', array(
            "user" => $this->getUser(),
            'atkList' => $this->getUser()->getOngoingAtks(),
        ));
    }
}
