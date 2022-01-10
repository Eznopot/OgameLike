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
            "user" => $this->getUser(),
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
        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();

        $allPlanet = $this->getDoctrine()->getRepository(Planets::class)->findAll();

        $unitsNbr = $request->request->get('Units');
        $planetId = $request->request->get('planetID');

        $allOnGoingAtk = $this->getUser()->getOngoingAtks();

        for ($i=0; $i < $allOnGoingAtk->count(); $i++) {
            $dateNow = new \DateTime('now');
            $dateBase = new \DateTime('2000-01-01');
            $endOnGoingAtk = $allOnGoingAtk[$i]->getEndTime();

            if ($endOnGoingAtk->format('Y-m-d h:i:s') < $dateNow->format('Y-m-d h:i:s')) {

                $uniteAtk = $allOnGoingAtk[$i]->getSuccessRate() - $allOnGoingAtk[$i]->getUnitsAtk();

                $allBuildUserEnemi = array();
                $planetAtk = $allOnGoingAtk[$i]->getPlanetId();
                for ($j=0; $j < $planetAtk->getPlayers()->count(); $j++) {
                    $BuildUserEnemie = $planetAtk->getPlayers()[$j]->getBatimentsOwned();
                    for ($k=0; $k < $BuildUserEnemie->count(); $k++) {
                        $allBuildUserEnemi[] = $BuildUserEnemie[$k];
                    }
                }

                while ($uniteAtk) {
                    $planetDeafet = true;
                    for ($j=0; $j < count($allBuildUserEnemi); $j++) {
                        if ($allBuildUserEnemi[$j]->getHp()) {
                            $planetDeafet = false;
                        }
                    }
                    if ($planetDeafet)
                        break;
                    $BuildUserEnemi = $allBuildUserEnemi[rand(0, count($allBuildUserEnemi) - 1)];
                    if ($BuildUserEnemi->getHp()) {
                        $BuildUserEnemi->setHp($BuildUserEnemi->getHp() - 1);
                        $em->persist($BuildUserEnemi);
                        $uniteAtk--;
                    }
                }
                $this->getUser()->removeOngoingAtk($allOnGoingAtk[$i]);
                $this->getUser()->setUnits($uniteAtk);

                $em->persist($this->getUser());
            }
        }

        if ($unitsNbr !== null and $planetId !== null) {
            $planetAtk = $this->getDoctrine()->getRepository(Planets::class)->find($planetId);
            $myPlanet = $this->getUser()->getPlanet()->getDistance();
            $diffDistance = $planetAtk->getDistance() - $myPlanet;
            $diffDistance = ($diffDistance < 0) ? $diffDistance * -1 : $diffDistance;

            $endAtk = new \DateTime('now');
            $endAtk->add(new \DateInterval('PT'.intval($diffDistance / 100).'S'));

            $damagePlanetAtk = 0;
            $hpPlanetAtk = 0;
            for ($i=0; $i < $planetAtk->getPlayers()->count(); $i++) {
                $BuildUserEnemie = $planetAtk->getPlayers()[$i]->getBatimentsOwned();
                for ($j=0; $j < $BuildUserEnemie->count(); $j++) {
                    $statBuild = $BuildUserEnemie[$j]->getType();
                    $damagePlanetAtk += $statBuild->getDamage() + ($statBuild->getDamagePerLvl() * $BuildUserEnemie[$j]->getLevel());
                    $hpPlanetAtk += $BuildUserEnemie[$j]->getHp();
                }
            }

            $ongoinAtk = new OngoingAtk();
            $ongoinAtk->setDifficuly($hpPlanetAtk)
                ->setSuccessRate($damagePlanetAtk)
                ->setStart(new \DateTime('now'))
                ->setEndTime($endAtk)
                ->addPlayerID($this->getUser())
                ->setPlanetID($planetAtk)
                ->setUnitsAtk($unitsNbr);
            $em->persist($ongoinAtk);
        }
        $em->flush();

        return $this->render('game/AttackPage.twig', array(
            "user" => $this->getUser(),
            "planetList" => $allPlanet
        ));
    }
}