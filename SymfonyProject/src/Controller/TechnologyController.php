<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\ManagerServices;

class TechnologyController extends AbstractController
{
    /** @var ManagerServices $ManagerServices */
    private $ManagerServices;

    public function __construct()
    {
        $this->ManagerServices = new ManagerServices();
    }

    #[Route('/technology', name: 'technology')]
    public function index(): Response
    {
        $this->ManagerServices->AllUpdater(
            $this->getDoctrine(),
            $this->getUser()
        );

        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        $upgradeId = $request->request->get('type');

        if ($upgradeId !== null) {
            for ($i=0; $i < count($this->getUser()->getUserTechnoOwned()); $i++) {
                if ($this->getUser()->getUserTechnoOwned()[$i]->getType()->getId() == $upgradeId &&
                $this->getUser()->getGold() >= $this->getUser()->getUserTechnoOwned()[$i]->getType()->getPrice()) {
                    $upgradeTime = $this->getUser()->getUserTechnoOwned()[$i]->getType()->getUpgradeTime();
                    $endUpgrade = new \DateTime('now');
                    $endUpgrade->add(new \DateInterval('PT'.$upgradeTime.'S'));

                    $this->getUser()->getUserTechnoOwned()[$i]->setEndupgrade($endUpgrade)
                        ->setStartupgrade(new \DateTime('now'))
                        ->setUpgrading(True);
                    $this->getUser()->setGold($this->getUser()->getGold() - $this->getUser()->getUserTechnoOwned()[$i]->getType()->getPrice());
                    $em->persist($this->getUser());
                    $em->persist($this->getUser()->getUserTechnoOwned()[$i]);
                    $em->flush();
                }
            }
        }


        return $this->render('technology/index.html.twig', [
            'user' => $this->getUser(),
            'technoOwned' => $this->getUser()->getUserTechnoOwned()
        ]);
    }
}
