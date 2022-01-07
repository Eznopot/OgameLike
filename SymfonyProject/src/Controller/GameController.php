<?php

namespace App\Controller;

use App\Services\atkServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    public function __construct(){

    }

    /**
     * @Route("/resources", name="resources_page")
     */
    public function resourcesPage() : Response {


        return $this->render('game/resourcesPage.twig', array(
            "goldAmount" => 1000,
            "unitAmount" => 32,
            "goldBuilding" => 12,
            "unitBuilding" => 6,
            "defenseBuilding" => 3
        ));
    }

    /**
     * @Route("/attack", name="attack_page")
     */
    public function attackPage() : Response {
        $atkServices = new atkServices();

        $planetArray = $atkServices->getPlanetList($this->getDoctrine());
        $ongoingAtk = $atkServices->getAtkList($this->getDoctrine());
        return $this->render('game/attackPage.twig', array(
            "unitAmount" => 100,
            "planetList" => $planetArray,
            "atkList" => $ongoingAtk
        ));
    }
}