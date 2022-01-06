<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnologiesController extends AbstractController
{
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
