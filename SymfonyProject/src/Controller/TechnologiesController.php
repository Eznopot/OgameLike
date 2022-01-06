<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnologiesController extends AbstractController
{
    #[Route('/technologies/ajax', name: 'technologies_ajax')]
    public function ajax(Request $request) {
        $technologies = $this->getDoctrine()
            ->getRepository(Technologies::class)
            ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach($technologies as $technology) {
                $temp = array(
                    'technology' => $technology,
                );
                $jsonData[$idx++] = $temp;
            } 
            return new JsonResponse($jsonData);
        }
        else {
            return $this->render('technologies/index.html.twig');
        }
    }

    #[Route('/technologies', name: 'technologies')]
    // public function index(ManagerRegistry $doctrine): Response
    public function index(): Response
    {
        // $technologies = $doctrine->getRepository(Technology::class)->findAll();
        // $ownedTechnologies = $doctrine->getRepository(Technology::class)->find($this->getUser()->getId());

        $goldPlayer = 10;

        $technolgiesStats = [
            [
                'price' => 10,
                'stats' => '',
                'lvl' => 3,

                'upgradeTime' => 5,
                'actualUpgradeTime' => 2,

                'name' => 'def',
                'explaine' => 'this technology is for upgrade the unites damage',
                'explaineStats' => 'all your unites got +5 dmg'
            ],
            [
                'upgradeTime' => 5,
                'actualUpgradeTime' => 1,

                'name' => 'attaque',
                'explaine' => 'this technology is for upgrade the build damage',
                'explaineStats' => 'all your build got +5 dmg'
            ],
            [
                'upgradeTime' => 5,
                'actualUpgradeTime' => 4,

                'name' => 'trest2',
                'explaine' => 'qeds',
                'explaineStats' => 'dqdq'
            ]
        ];

        return $this->render('technologies/index.html.twig', [
            'goldPlayer' => $goldPlayer,
            'technolgiesStats' => $technolgiesStats,
        ]);
    }
}
