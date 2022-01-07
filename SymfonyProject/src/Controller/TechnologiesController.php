<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TechnologiesOwned;

// use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
// use Doctrine\ORM\EntityManager;

class TechnologiesController extends AbstractController
{
    // private ManagerRegistry $doctrine;

    public function __construct()
    {
        // $this->doctrine = $doctrine;
    }

    #[Route('/technologies/ajax', name: 'technologies_ajax')]
    public function ajax(Request $request) {
    }

    #[Route('/technologies', name: 'technologies')]
    public function index(): Response
    {
        $request = Request::createFromGlobals();
        $upgradeId = $request->request->get('type');

        if ($upgradeId !== null) {
            for ($i=0; $i < count($this->getUser()->getUserTechnoOwned()); $i++) {
                if ($this->getUser()->getUserTechnoOwned()[$i]->getType()->getId() == $upgradeId) {
                    $this->getUser()->getUserTechnoOwned()[$i]->setStartupgrade(new \DateTime('now'));

                    $upgradeTime = $this->getUser()->getUserTechnoOwned()[$i]->getType()->getUpgradeTime();
                    $endUpgrade = new \DateTime('now');
                    $endUpgrade->add(new \DateInterval('PT'.$upgradeTime.'M'));
                    $this->getUser()->getUserTechnoOwned()[$i]->setEndupgrade($endUpgrade);
                }
            }
        }
        dump($this->getUser()->getUserTechnoOwned());

        return $this->render('technologies/index.html.twig', [
            'technoOwned' => $this->getUser()->getUserTechnoOwned()
        ]);
    }
}
