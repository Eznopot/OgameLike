<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TechnologiesController extends AbstractController
{
    #[Route('/technologies', name: 'technologies')]
    public function index(): Response
    {
        $response = new StreamedResponse();
        // $response->setCallback(function () {
        //     var_dump('Hello World');
        //     flush();

        //     sleep(2);

        //     var_dump('Hello World 2');
        //     flush();
        // });

        // $response->send();

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

        $Object = new \DateTime();  
        $DateAndTime = $Object->format("d-m-Y h:i:s a");  
        echo "";
        
        return $this->render('technologies/index.html.twig', [
            'controller_name' => 'TechnologiesController',

            'goldPlayer' => $goldPlayer,

            'technolgiesStats' => $technolgiesStats,

            'timeupdate' => 'The current date and time are '.$response

        ]);
    }
}

// "width: %;"