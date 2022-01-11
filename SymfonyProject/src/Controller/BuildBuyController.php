<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Batiments;
use App\Entity\BatimentOwned;
use App\Services\ManagerServices;

class BuildBuyController extends AbstractController
{
    /** @var ManagerServices $ManagerServices */
    private $ManagerServices;

    public function __construct()
    {
        $this->ManagerServices = new ManagerServices();
    }

    #[Route('/build/buy', name: 'build_buy')]
    public function index(): Response
    {
        $this->ManagerServices->AllUpdater(
            $this->getDoctrine(),
            $this->getUser()
        );

        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        $buyId = $request->request->get('buy');
        $upgradeId = $request->request->get('upgrade');

        if ($buyId !== null) {
            $buildBuy = $this->getDoctrine()->getRepository(Batiments::class)->find($buyId);

            if ($this->getUser()->getGold() >= $buildBuy->getPrice()) {
                $endUpgrade = new \DateTime('now');
                $endUpgrade->add(new \DateInterval('PT'.$buildBuy->getUpgradeTime().'S'));

                $levelBuild = 0;
                for ($i=0; $i < count($this->getUser()->getBatimentsOwned()); $i++) {
                    if ($this->getUser()->getBatimentsOwned()[$i]->getType()->getId() == $buyId) {
                        $levelBuild = $this->getUser()->getBatimentsOwned()[$i]->getLevel();
                        break;
                    }
                }

                $newBuild = new BatimentOwned($buildBuy);
                $newBuild->setType($buildBuy)
                        ->setLevel($levelBuild)
                        ->setStartupgrade(new \DateTime('now'))
                        ->setEndupgrade($endUpgrade)
                        ->setUpgrading(True)
                        ->setHp($buildBuy->getHp() + ($buildBuy->getHpPerLvl() * $newBuild->getLevel()))
                        ->setUpgradingType('Buy');
                $em->persist($newBuild);

                $this->getUser()->addBatimentsOwned($newBuild);

                $this->getUser()->setGold($this->getUser()->getGold() - $buildBuy->getPrice());
                $em->persist($this->getUser());
                $em->flush();
            }
        }

        if ($upgradeId !== null) {
            for ($i=0; $i < count($this->getUser()->getBatimentsOwned()); $i++) {
                if ($this->getUser()->getBatimentsOwned()[$i]->getType()->getId() == $upgradeId &&
                    $this->getUser()->getGold() >= $this->getUser()->getBatimentsOwned()[$i]->getType()->getPrice()) {

                    $upgradeTime = $this->getUser()->getBatimentsOwned()[$i]->getType()->getUpgradeTime();
                    $endUpgrade = new \DateTime('now');
                    $endUpgrade->add(new \DateInterval('PT'.$upgradeTime.'S'));

                    $this->getUser()->getBatimentsOwned()[$i]->setEndupgrade($endUpgrade)
                        ->setStartupgrade(new \DateTime('now'))
                        ->setUpgrading(True)
                        ->setUpgradingType('Upgrading');
                    $em->persist($this->getUser()->getBatimentsOwned()[$i]);
                    $em->flush();
                }
            }
        }

        $building = $this->getDoctrine()->getRepository(Batiments::class)->findAll();

        $goldBuilding = array();
        $uniteBuilding = array();
        $damageBuilding = array();

        foreach ($building as $build) {
            if ($build->getDamage() != 0) {
                array_push($damageBuilding, $build);
            }

            if ($build->getUnitesPerHour() != 0) {
                array_push($uniteBuilding, $build);
            }

            if ($build->getGoldPerHour() != 0) {
                array_push($goldBuilding, $build);
            }
        }

        $category = array(
            'Gold',
            'Unite',
            'Damage'
        );
        return $this->render('build_buy/index.html.twig', [
            'user' => $this->getUser(),
            'category' => $category,
            'allBuilding' => [$goldBuilding, $uniteBuilding, $damageBuilding],
            'buildingsOwned' => $this->getUser()->getBatimentsOwned()
        ]);
    }
}
