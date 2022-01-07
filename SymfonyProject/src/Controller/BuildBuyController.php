<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Batiments;

class BuildBuyController extends AbstractController
{
    #[Route('/build/buy', name: 'build_buy')]
    public function index(): Response
    {
        $request = Request::createFromGlobals();
        $buyId = $request->request->get('buy');
        $upgradeId = $request->request->get('upgrade');

        if ($buyId !== null) {
            dump($buyId);
        }

        if ($upgradeId !== null) {
            dump($upgradeId);
        }

        $building = $this->getDoctrine()->getRepository(Batiments::class)->findAll();

        $goldBuilding = array();
        $uniteBuilding = array();
        $damageBuilding = array();

        foreach ($building as $build) {
            if ($build->getDamage() != 0) {
                array_push($damageBuilding, $build);
            }

            // if ($build.getUnitePerHour != 0) {
                // array_push($uniteBuilding, $build);
            // }

            if ($build->getGoldPerHour() != 0) {
                array_push($goldBuilding, $build);
            }
        }

        return $this->render('build_buy/index.html.twig', [
            'allBuilding' => [$goldBuilding, $uniteBuilding, $damageBuilding],
            'goldBuilding' => $goldBuilding,
            'uniteBuilding' => $uniteBuilding,
            'damageBuilding' => $damageBuilding
        ]);
    }
}
