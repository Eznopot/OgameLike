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
        $addGold = $this->getUser()->getGold();
        $addUnites = $this->getUser()->getUnits();

        for ($i=0; $i < count($buildingsOwned); $i++) {
            if ($buildingsOwned[$i]->getHp()) {
                $addGold += ($buildingsOwned[$i]->getType()->getGoldPerHour() / 3600) * $needToAddInTime;
                $addUnites += ($buildingsOwned[$i]->getType()->getUnitesPerHour() / 3600) * $needToAddInTime;
            }
        }

        $this->getUser()->setGold($addGold)
                    ->setUnits($addUnites)
                    ->setlastUpdate($dateNow);

        $em->persist($this->getUser());
        $em->flush();

        return $this->render('build_production/index.html.twig', [
            'user' => $this->getUser(),
            'buildingsOwned' => $buildingsOwned
        ]);
    }
}
