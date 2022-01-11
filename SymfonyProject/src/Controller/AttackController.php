<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ManagerServices;
use App\Entity\OngoingAtk;
use App\Entity\Planets;

class AttackController extends AbstractController
{
    /** @var ManagerServices $ManagerServices */
    private $ManagerServices;

    public function __construct()
    {
        $this->ManagerServices = new ManagerServices();
    }

    #[Route('/attack', name: 'attack')]
    public function index(): Response
    {
        $this->ManagerServices->AllUpdater(
            $this->getDoctrine(),
            $this->getUser()
        );

        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();

        $unitsNbr = $request->request->get('Units');
        $planetId = $request->request->get('planetID');

        if ($unitsNbr !== null and $planetId !== null) {
            $planetAtk = $this->getDoctrine()->getRepository(Planets::class)->find($planetId);
            $myPlanet = $this->getUser()->getPlanet()->getDistance();
            $diffDistance = $planetAtk->getDistance() - $myPlanet;
            $diffDistance = ($diffDistance < 0) ? $diffDistance * -1 : $diffDistance;

            $endAtk = new \DateTime('now');
            $endAtk->add(new \DateInterval('PT'.intval($diffDistance / 100).'S'));

            $damagePlanetAtk = 0;
            $hpPlanetAtk = 0;
            $addDamageTechnoEnemie = 0;
            for ($i=0; $i < $planetAtk->getPlayers()->count(); $i++) {
                $userEnemie = $planetAtk->getPlayers()[$i];

                for ($j=0; $j < count($userEnemie->getUserTechnoOwned()); $j++) {
                    $technoUserEnnemie = $userEnemie->getUserTechnoOwned()[$j];
                    $addDamageTechnoEnemie = (
                        $technoUserEnnemie->getLevel() * 
                        $technoUserEnnemie->getType()->getDamagePerLevel()
                    );
                }

                $BuildUserEnemie = $userEnemie->getBatimentsOwned();
                for ($j=0; $j < $BuildUserEnemie->count(); $j++) {
                    $statBuild = $BuildUserEnemie[$j]->getType();
                    if ($statBuild->getHp() > 0) {
                        $damagePlanetAtk += (
                            $statBuild->getDamage() + 
                            ($statBuild->getDamagePerLvl() * $statBuild->getLevel() + 
                            $addDamageTechnoEnemie)
                        );
                        $hpPlanetAtk += $statBuild->getHp();
                    }
                }
            }

            $addDamageTechno = 0;
            for ($i=0; $i < $this->getUser()->getUserTechnoOwned()->count(); $i++) { 
                $technoUser = $this->getUser()->getUserTechnoOwned()[$i];
                $addDamageTechno = (
                    $addDamageTechno +
                    $technoUser->getType()->getDamage() +
                    $technoUser->getLevel() * 
                    $technoUser->getType()->getDamagePerLevel()
                );
            }

            $ongoinAtk = new OngoingAtk();
            $ongoinAtk->setDifficuly($hpPlanetAtk)
                ->setSuccessRate($damagePlanetAtk)
                ->setStart(new \DateTime('now'))
                ->setEndTime($endAtk)
                ->setPlayerID($this->getUser())
                ->setPlanets($planetAtk)
                ->setUnitsAtk($unitsNbr)
                ->setIdEnded(false)
                ->setTechnologiesBonus($addDamageTechno);

            $this->getUser()->setUnits($this->getUser()->getUnits() - $unitsNbr);
            $em->persist($this->getUser());
            $em->persist($ongoinAtk);
        }
        $em->flush();

        return $this->render('attack/index.html.twig', [
            "user" => $this->getUser(),
            "planetList" => $this->getDoctrine()->getRepository(Planets::class)->findAll()
        ]);
    }
}
