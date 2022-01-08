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
            $dateBase = new \DateTime('2000-01-01');
            $endUpgrade = $this->getUser()->getBatimentsOwned()[$i]->getEndupgrade();

            if ($endUpgrade->format('Y-m-d h:i:s') < $dateNow->format('Y-m-d h:i:s') &&
                $endUpgrade->format('Y-m-d h:i:s') != $dateBase->format('Y-m-d h:i:s')) {

                $this->getUser()->getBatimentsOwned()[$i]->setUpgrading(False)
                    ->setEndupgrade($dateBase)
                    ->setStartupgrade($dateBase)
                    ->setLevel($this->getUser()->getBatimentsOwned()[$i]->getLevel() + 1);

                $em->persist($this->getUser()->getBatimentsOwned()[$i]);
                $em->flush();
            }
        }

        if ($buyId !== null) {
            $buildBuy = $this->getDoctrine()->getRepository(Batiments::class)->find($buyId);

            $endUpgrade = new \DateTime('now');
            $endUpgrade->add(new \DateInterval('PT'.$buildBuy->getUpgradeTime().'S'));

            $newBuild = new BatimentOwned($buildBuy);
            $newBuild->setType($buildBuy)
                    ->setLevel(0)
                    ->setStartupgrade(new \DateTime('now'))
                    ->setEndupgrade($endUpgrade)
                    ->setUpgrading(True);
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
                        ->setUpgrading(True);
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
        dump($goldBuilding);
        return $this->render('build_buy/index.html.twig', [
            'category' => $category,
            'allBuilding' => [$goldBuilding, $uniteBuilding, $damageBuilding],
            'buildingsOwned' => $this->getUser()->getBatimentsOwned()
        ]);
    }
}
