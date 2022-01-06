<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnologiesController extends AbstractController
{
    #[Route('/technologies', name: 'technologies')]
    public function index(): Response
    {
        $goldPlayer = 10;

        $technolgiesStats = [
            [
                'price' => 10,
                'stats' => '',
                'lvl' => 3,

                'upgradeTime' => 5,
                'actualUpgradeTime' => 0,

                'name' => 'def',
                'explaine' => 'this technology is for upgrade the unites damage',
                'explaineStats' => 'all your unites got +5 dmg'
            ],
            [
                'upgradeTime' => 5,
                'actualUpgradeTime' => 0,

                'name' => 'attaque',
                'explaine' => 'this technology is for upgrade the build damage',
                'explaineStats' => 'all your build got +5 dmg'
            ],
            [
                'upgradeTime' => 5,
                'actualUpgradeTime' => 0,

                'name' => 'trest2',
                'explaine' => 'qeds',
                'explaineStats' => 'dqdq'
            ]
        ];

        return $this->render('technologies/index.html.twig', [
            'controller_name' => 'TechnologiesController',
            'goldPlayer' => $goldPlayer,
            'technolgiesStats' => $technolgiesStats,
        ]);
    }
}

// "width: %;"