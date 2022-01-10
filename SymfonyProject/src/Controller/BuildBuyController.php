<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Batiments;
use App\Entity\BatimentOwned;

class BuildBuyController extends AbstractController
{
    #[Route('/build/buy', name: 'build_buy')]
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        $buyId = $request->request->get('buy');
        $upgradeId = $request->request->get('upgrade');

        for ($i=0; $i < count($this->getUser()->getBatimentsOwned()); $i++) {
            $dateNow = new \DateTime('now');
            $buildOwned = $this->getUser()->getBatimentsOwned()[$i];
            $endUpgrade = $buildOwned->getEndupgrade();

            if ($endUpgrade != null && $endUpgrade->format('Y-m-d h:i:s') < $dateNow->format('Y-m-d h:i:s')) {

                if ($buildOwned->getUpgradingType() == 'Upgrading') {
                    $buildOwned->setLevel($buildOwned->getLevel() + 1);
                }

                $buildOwned->setUpgrading(False)
                    ->setEndupgrade(null)
                    ->setStartupgrade(null)
                    ->setUpgradingType(null);

                $em->persist($buildOwned);
                $em->flush();
            }
        }

        if ($buyId !== null) {
            $buildBuy = $this->getDoctrine()->getRepository(Batiments::class)->find($buyId);

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

            $em->flush();
        }

        if ($upgradeId !== null) {
            for ($i=0; $i < count($this->getUser()->getBatimentsOwned()); $i++) {
                if ($this->getUser()->getBatimentsOwned()[$i]->getType()->getId() == $upgradeId) {
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
            'gold',
            'unite',
            'damage'
        );
        return $this->render('build_buy/index.html.twig', [
            'user' => $this->getUser(),
            'category' => $category,
            'allBuilding' => [$goldBuilding, $uniteBuilding, $damageBuilding],
            'buildingsOwned' => $this->getUser()->getBatimentsOwned()
        ]);
    }
}
