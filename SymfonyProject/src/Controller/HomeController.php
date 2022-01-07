<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        $user = $this->getUser();
        $technoOwned = $user->getUserTechnoOwned();
        $batOwned = $user->getBatimentsOwned();
        $arrayOfTechno = array();
        foreach ($technoOwned as $elem) {
            array_push($arrayOfTechno, $elem->getType());
        }
        $arrayOfBat = array();
        foreach ($batOwned as $elem) {
            array_push($arrayOfBat, $elem->getType());
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'technos_owned' => $arrayOfTechno,
            'batiments_owned' => $arrayOfBat
        ]);
    }
}
