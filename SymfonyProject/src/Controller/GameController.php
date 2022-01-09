<?php

namespace App\Controller;

use App\Entity\OngoingAtk;
use App\Entity\Planets;
use App\Entity\User;
use App\Services\atkServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            "goldAmount" => $this->getUser()->getGold(),
            "unitAmount" => $this->getUser()->getUnits(),
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
        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        $unitNbr = $request->request->get('Units');

        /** @var Planets $planet */
        $planet = null;

        for ($i=0; $i < count($planetArray); $i++)
        {
            if($planetArray[$i]->getId() == $request->request->get('planetID')) {
               $planet = $planetArray[$i];
               break;
            }
            $dateNow = new \DateTime('now');
            $dateBase = new \DateTime('2000-01-01');
            if ($planetArray[$i]->isUnderAtk() !== false &&
                $planetArray[$i]->getOngoingAtk()->getEndTime()->format('Y-m-d h:i:s') < $dateNow->format('Y-m-d h:i:s') &&
                $planetArray[$i]->getOngoingAtk()->getEndTime()->format('Y-m-d h:i:s')  != $dateBase->format('Y-m-d h:i:s'))
            {
                $planetArray[$i]->getOngoingAtk()->getPlayerID()->setGold($planetArray[$i]->getOngoingAtk()->getPlayerID()->getGold() + ($planetArray[$i]->getDefenseLvl() * 100));
                $em->persist($planetArray[$i]->getOngoingAtk()->getPlayerID());
            }
        }
        if ($unitNbr != 0 and $planet !== null) {
            $atk = new OngoingAtk();
            $endTime = new \DateTime('now');
            $endTime->add(new \DateInterval('PT'.$planet->getDistance().'S'));
            $atk->setDifficuly($planet->getDefenseLvl())
                ->setSuccessRate((5 - $planet->getDefenseLvl()) * 20 + ($unitNbr*2))
                ->setStart(new \DateTime('now'))
                ->setEndTime($endTime)
                ->addPlayerID($this->getUser())
                ->setPlanetID($planet);
            $em->persist($atk);
            $this->getUser()->setUnits($this->getUser()->getUnits() - $unitNbr);

            $em->persist($this->getUser());

            $planet->setOngoingAtk($atk);
            $em->persist($planet);
            $em->flush();
        }

        return $this->render('game/AttackPage.twig', array(
            "user" => $this->getUser(),
            "unitAmount" => $this->getUser()->getUnits(),
            "planetList" => $planetArray,
            "atkList" => $ongoingAtk
        ));
    }
}