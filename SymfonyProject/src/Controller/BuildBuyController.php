<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BuildBuyController extends AbstractController
{
    #[Route('/build/buy', name: 'build_buy')]
    public function index(): Response
    {
        $BuildingsStats = [
            [
                'name' => 'def',
                'explaine' => 'truc truc truc',
                'explaineStats' => 'dmg',
                'actualUpgradeTime' => 2,
                'upgradeTime' => 5
            ]
        ];

        return $this->render('build_buy/index.html.twig', [
            'controller_name' => 'BuildBuyController',
            'BuildingsStats' => $BuildingsStats
        ]);
    }
}
