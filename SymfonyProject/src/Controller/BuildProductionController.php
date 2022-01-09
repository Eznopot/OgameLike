<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BuildProductionController extends AbstractController
{

    #[Route('/build/production', name: 'build_production')]
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $dateNow = new \DateTime('now');
        $buildingsOwned = $this->getUser()->getBatimentsOwned();
        $needToAddInTime = $this->getUser()->getLastUpdate()->diff($dateNow);
        $needToAddInTime = $needToAddInTime->s + $needToAddInTime->i * 60 + $needToAddInTime->h * 3600 + $needToAddInTime->d * 86400;
        $addGold = 0;

        for ($i=0; $i < count($buildingsOwned); $i++) {
            $addGold += ($buildingsOwned[$i]->getType()->getGoldPerHour() / 3600) * $needToAddInTime;
        }

        dump($addGold);

        // $this->getUser()->setLastUpdate();

        return $this->render('build_production/index.html.twig', [
            'User' => $this->getUser(),
            'buildingsOwned' => $buildingsOwned
        ]);
    }
}
